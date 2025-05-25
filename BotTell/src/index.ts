import TelegramBot from 'node-telegram-bot-api';
import mysql from 'mysql2/promise';
import dotenv from 'dotenv';

// Load environment variables
dotenv.config();

// Bot configuration
const token = process.env.TELEGRAM_BOT_TOKEN;
if (!token) {
  console.error('TELEGRAM_BOT_TOKEN is not defined in .env file');
  process.exit(1);
}

// Create a bot instance
const bot = new TelegramBot(token, { polling: true });

// Database configuration
const dbConfig = {
  host: process.env.DB_HOST || 'localhost',
  port: parseInt(process.env.DB_PORT || '3306'),
  database: process.env.DB_DATABASE,
  user: process.env.DB_USERNAME,
  password: process.env.DB_PASSWORD,
};

// Create a database connection pool
const pool = mysql.createPool(dbConfig);

// Interface for Post with ingredients
interface Post {
  id: number;
  title: string;
  content: string;
  image: string;
  ingredients: string[];
}

// Function to search for recipes by ingredients
async function searchRecipesByIngredients(ingredients: string[]): Promise<Post[]> {
  try {
    // Normalize ingredients (trim, lowercase)
    const normalizedIngredients = ingredients.map(i => i.trim().toLowerCase());
    
    // Create placeholders for SQL query
    const placeholders = normalizedIngredients.map(() => '?').join(',');
    
    // SQL query to find posts that have the specified ingredients
    const query = `
      SELECT p.id, p.title, p.content, p.image, COUNT(DISTINCT i.id) as ingredient_match_count
      FROM posts p
      JOIN ingredients i ON p.id = i.post_id
      WHERE LOWER(i.name) IN (${placeholders})
      GROUP BY p.id, p.title, p.content, p.image
      ORDER BY ingredient_match_count DESC
    `;
    
    // Execute the query
    const [rows] = await pool.query(query, normalizedIngredients);
    const posts = rows as any[];
    
    // For each post, fetch its ingredients
    const postsWithIngredients: Post[] = await Promise.all(
      posts.map(async (post) => {
        const [ingredientRows] = await pool.query(
          'SELECT name FROM ingredients WHERE post_id = ?',
          [post.id]
        );
        
        return {
          id: post.id,
          title: post.title,
          content: post.content,
          image: post.image,
          ingredients: (ingredientRows as any[]).map(row => row.name)
        };
      })
    );
    
    return postsWithIngredients;
  } catch (error) {
    console.error('Error searching recipes:', error);
    return [];
  }
}

// Function to get all recipes with pagination
async function getAllRecipes(page: number = 1, limit: number = 5): Promise<{recipes: Post[], total: number}> {
  try {
    const offset = (page - 1) * limit;
    
    // Get total count
    const [countResult] = await pool.query('SELECT COUNT(*) as total FROM posts');
    const total = (countResult as any[])[0].total;
    
    // Get recipes for current page
    const query = `
      SELECT id, title, content, image 
      FROM posts 
      ORDER BY id DESC 
      LIMIT ? OFFSET ?
    `;
    
    const [rows] = await pool.query(query, [limit, offset]);
    const posts = rows as any[];
    
    // For each post, fetch its ingredients
    const postsWithIngredients: Post[] = await Promise.all(
      posts.map(async (post) => {
        const [ingredientRows] = await pool.query(
          'SELECT name FROM ingredients WHERE post_id = ?',
          [post.id]
        );
        
        return {
          id: post.id,
          title: post.title,
          content: post.content,
          image: post.image,
          ingredients: (ingredientRows as any[]).map(row => row.name)
        };
      })
    );
    
    return { recipes: postsWithIngredients, total };
  } catch (error) {
    console.error('Error getting all recipes:', error);
    return { recipes: [], total: 0 };
  }
}

// Function to send recipe list with pagination
async function sendRecipeList(chatId: number, page: number = 1) {
  const limit = 5; // Number of recipes per page
  const { recipes, total } = await getAllRecipes(page, limit);
  
  if (recipes.length === 0) {
    bot.sendMessage(chatId, 'متأسفانه هیچ دستور پختی یافت نشد.');
    return;
  }
  
  const totalPages = Math.ceil(total / limit);
  
  let message = `📋 *لیست دستورهای پخت* (صفحه ${page} از ${totalPages})\n\n`;
  
  recipes.forEach((recipe, index) => {
    message += `${index + 1}. *${recipe.title}*\n`;
  });
  
  // Create inline keyboard for pagination and recipe selection
  const keyboard: TelegramBot.InlineKeyboardButton[][] = [];
  
  // Add recipe selection buttons
  recipes.forEach((recipe, index) => {
    keyboard.push([{
      text: `${index + 1}. ${recipe.title}`,
      callback_data: `recipe:${recipe.id}`
    }]);
  });
  
  // Add pagination buttons
  const paginationRow: TelegramBot.InlineKeyboardButton[] = [];
  
  if (page > 1) {
    paginationRow.push({
      text: '« قبلی',
      callback_data: `list:${page - 1}`
    });
  }
  
  if (page < totalPages) {
    paginationRow.push({
      text: 'بعدی »',
      callback_data: `list:${page + 1}`
    });
  }
  
  if (paginationRow.length > 0) {
    keyboard.push(paginationRow);
  }
  
  await bot.sendMessage(chatId, message, {
    parse_mode: 'Markdown',
    reply_markup: {
      inline_keyboard: keyboard
    }
  });
}

// Function to send recipe details
async function sendRecipeDetails(chatId: number, recipeId: number) {
  try {
    // Get recipe details
    const [rows] = await pool.query(
      'SELECT id, title, content, image FROM posts WHERE id = ?',
      [recipeId]
    );
    
    if ((rows as any[]).length === 0) {
      bot.sendMessage(chatId, 'دستور پخت مورد نظر یافت نشد.');
      return;
    }
    
    const recipe = (rows as any[])[0];
    
    // Get ingredients
    const [ingredientRows] = await pool.query(
      'SELECT name, amount, unit FROM ingredients WHERE post_id = ? ORDER BY `order`',
      [recipeId]
    );
    
    const ingredients = (ingredientRows as any[]);
    
    // Format recipe message
    let ingredientList = '';
    ingredients.forEach((ingredient) => {
      const amount = ingredient.amount ? `${ingredient.amount} ` : '';
      const unit = ingredient.unit ? `${ingredient.unit} ` : '';
      ingredientList += `• ${amount}${unit}${ingredient.name}\n`;
    });
    
    // Create a shortened content preview (first 200 characters)
    const contentPreview = recipe.content.length > 200 
      ? recipe.content.substring(0, 197) + '...' 
      : recipe.content;
    
    const message = `🍲 *${recipe.title}*\n\n` +
                   `📝 *مواد لازم:*\n${ingredientList}\n` +
                   `📖 *دستور پخت:*\n${contentPreview}\n\n` +
                   `🔗 [مشاهده دستور کامل](http://localhost/Website/test/foodieblog/posts/${recipe.id})`;
    
    // Create back button
    const keyboard = {
      inline_keyboard: [
        [{ text: 'بازگشت به لیست', callback_data: 'list:1' }]
      ]
    };
    
    try {
      // If the post has an image, send it with the message
      if (recipe.image) {
        await bot.sendPhoto(chatId, `http://localhost/Website/test/foodieblog/storage/${recipe.image}`, {
          caption: message,
          parse_mode: 'Markdown',
          reply_markup: keyboard
        });
      } else {
        // Otherwise just send the text
        await bot.sendMessage(chatId, message, { 
          parse_mode: 'Markdown',
          reply_markup: keyboard
        });
      }
    } catch (error) {
      console.error('Error sending recipe details:', error);
      await bot.sendMessage(chatId, message, { 
        parse_mode: 'Markdown',
        reply_markup: keyboard
      });
    }
  } catch (error) {
    console.error('Error fetching recipe details:', error);
    bot.sendMessage(chatId, 'خطایی در دریافت اطلاعات دستور پخت رخ داد. لطفاً دوباره تلاش کنید.');
  }
}

// Start command handler
bot.onText(/\/start/, (msg) => {
  const chatId = msg.chat.id;
  const keyboard = {
    keyboard: [
      [{ text: '📋 مشاهده لیست دستورها' }],
      [{ text: '❓ راهنما' }]
    ],
    resize_keyboard: true
  };
  
  bot.sendMessage(
    chatId,
    'سلام! به ربات جستجوی دستور پخت غذا خوش آمدید. 👨‍🍳\n\n' +
    'لطفاً مواد اولیه‌ای که دارید را وارد کنید (هر ماده در یک خط):\n\n' +
    'مثال:\n' +
    'سیب زمینی\n' +
    'تخم مرغ\n' +
    'پیاز\n\n' +
    'یا از دکمه‌های زیر استفاده کنید:',
    {
      reply_markup: keyboard
    }
  );
});

// Help command handler
bot.onText(/\/help/, (msg) => {
  const chatId = msg.chat.id;
  bot.sendMessage(
    chatId,
    'راهنمای استفاده از ربات:\n\n' +
    '1. مواد اولیه‌ای که دارید را وارد کنید (هر ماده در یک خط)\n' +
    '2. ربات دستورهای پخت مرتبط با مواد شما را نمایش می‌دهد\n' +
    '3. با دکمه «مشاهده لیست دستورها» می‌توانید همه دستورها را ببینید\n' +
    '4. برای شروع مجدد، دستور /start را وارد کنید\n' +
    '5. برای مشاهده این راهنما، دستور /help را وارد کنید'
  );
});

// List command handler
bot.onText(/\/list/, (msg) => {
  const chatId = msg.chat.id;
  sendRecipeList(chatId, 1);
});

// Handle callback queries (for pagination and recipe selection)
bot.on('callback_query', async (callbackQuery) => {
  const chatId = callbackQuery.message?.chat.id;
  if (!chatId) return;
  
  const data = callbackQuery.data;
  if (!data) return;
  
  // Acknowledge the callback query
  await bot.answerCallbackQuery(callbackQuery.id);
  
  if (data.startsWith('list:')) {
    // Handle pagination
    const page = parseInt(data.split(':')[1]);
    await sendRecipeList(chatId, page);
  } else if (data.startsWith('recipe:')) {
    // Handle recipe selection
    const recipeId = parseInt(data.split(':')[1]);
    await sendRecipeDetails(chatId, recipeId);
  }
});

// Handle text messages (ingredient lists or button clicks)
bot.on('message', async (msg) => {
  // Ignore commands
  if (msg.text?.startsWith('/')) return;
  
  const chatId = msg.chat.id;
  const text = msg.text || '';
  
  // Handle button clicks
  if (text === '📋 مشاهده لیست دستورها') {
    sendRecipeList(chatId, 1);
    return;
  }
  
  if (text === '❓ راهنما') {
    bot.sendMessage(
      chatId,
      'راهنمای استفاده از ربات:\n\n' +
      '1. مواد اولیه‌ای که دارید را وارد کنید (هر ماده در یک خط)\n' +
      '2. ربات دستورهای پخت مرتبط با مواد شما را نمایش می‌دهد\n' +
      '3. با دکمه «مشاهده لیست دستورها» می‌توانید همه دستورها را ببینید\n' +
      '4. برای شروع مجدد، دستور /start را وارد کنید\n' +
      '5. برای مشاهده این راهنما، دستور /help را وارد کنید'
    );
    return;
  }
  
  // Handle ingredient lists
  // Split the message by new lines to get individual ingredients
  const ingredients = text.split('\n').filter(line => line.trim() !== '');
  
  if (ingredients.length === 0) {
    bot.sendMessage(chatId, 'لطفاً حداقل یک ماده اولیه وارد کنید.');
    return;
  }
  
  // Send a "typing" action
  bot.sendChatAction(chatId, 'typing');
  
  // Search for recipes
  const recipes = await searchRecipesByIngredients(ingredients);
  
  if (recipes.length === 0) {
    bot.sendMessage(
      chatId,
      'متأسفانه دستور پختی با مواد اولیه شما پیدا نشد. لطفاً مواد دیگری را امتحان کنید.'
    );
    return;
  }
  
  // Send the results
  bot.sendMessage(
    chatId,
    `${recipes.length} دستور پخت با مواد اولیه شما پیدا شد:`
  );
  
  // Send each recipe
  for (const recipe of recipes.slice(0, 5)) { // Limit to 5 recipes to avoid spam
    const ingredientList = recipe.ingredients.join('، ');
    const message = `🍲 *${recipe.title}*\n\n` +
                   `📝 *مواد لازم:* ${ingredientList}\n\n` +
                   `🔗 [مشاهده دستور کامل](http://localhost/Website/test/foodieblog/posts/${recipe.id})`;
    
    try {
      // If the post has an image, send it with the message
      if (recipe.image) {
        await bot.sendPhoto(chatId, `http://localhost/Website/test/foodieblog/storage/${recipe.image}`, {
          caption: message,
          parse_mode: 'Markdown'
        });
      } else {
        // Otherwise just send the text
        await bot.sendMessage(chatId, message, { parse_mode: 'Markdown' });
      }
    } catch (error) {
      console.error('Error sending message:', error);
      await bot.sendMessage(chatId, message, { parse_mode: 'Markdown' });
    }
  }
  
  if (recipes.length > 5) {
    bot.sendMessage(
      chatId,
      `و ${recipes.length - 5} دستور پخت دیگر. برای دیدن همه نتایج به وبسایت مراجعه کنید.`
    );
  }
});

// Error handling
bot.on('polling_error', (error) => {
  console.error('Polling error:', error);
});

console.log('Bot is running...');