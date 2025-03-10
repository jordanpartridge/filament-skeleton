import puppeteer from 'puppeteer';

async function checkDashboard() {
  const browser = await puppeteer.launch({
    headless: "new",
    args: ['--no-sandbox']
  });
  
  const page = await browser.newPage();
  
  try {
    // Navigate to login page
    await page.goto('http://filament-skeleton.test/admin/login', { waitUntil: 'networkidle2' });
    console.log('Successfully loaded login page');
    
    // Take a screenshot of the login page
    await page.screenshot({ path: 'login-page.png' });
    
    // Wait for form to be visible
    await page.waitForSelector('form');
    
    // Take a screenshot to see what the form looks like
    await page.screenshot({ path: 'login-form.png' });
    
    // Find the actual form fields
    const inputs = await page.$$('input');
    console.log(`Found ${inputs.length} input fields`);
    
    // Get input field names
    const inputNames = await page.evaluate(() => {
      return Array.from(document.querySelectorAll('input')).map(input => {
        return {
          name: input.name,
          id: input.id,
          type: input.type
        };
      });
    });
    console.log('Form inputs:', JSON.stringify(inputNames, null, 2));
    
    // Fill in login credentials using the detected fields
    if (inputNames.length > 0) {
      // Assuming the first input is email and the second is password
      await page.type(`#${inputNames[0].id}`, 'admin@example.com');
      if (inputNames.length > 1) {
        await page.type(`#${inputNames[1].id}`, 'password');
      }
    }
    
    // Click the login button and wait for navigation
    await Promise.all([
      page.click('button[type="submit"]'),
      page.waitForNavigation({ waitUntil: 'networkidle2' })
    ]);
    
    console.log('Successfully logged in');
    
    // Navigate to dashboard
    await page.goto('http://filament-skeleton.test/admin/dashboard', { waitUntil: 'networkidle2' });
    console.log('Successfully loaded dashboard page');
    
    // Take a screenshot of the dashboard
    await page.screenshot({ path: 'dashboard.png' });
    
    // Check for error messages on the page
    const errorText = await page.evaluate(() => {
      const errorElements = document.querySelectorAll('.text-danger, .alert-danger, .error');
      return Array.from(errorElements).map(el => el.textContent);
    });
    
    if (errorText.length > 0) {
      console.log('Errors found on page:', errorText);
    } else {
      console.log('No visible errors on the dashboard');
    }
    
  } catch (error) {
    console.error('Error during test:', error);
  } finally {
    await browser.close();
  }
}

checkDashboard();