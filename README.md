📄 README
📌 Project Name: WEBMISTRY
📂 Project Structure
Your project has folders like:

assets/

att/

attendance/

forms/

Invent/

Tools/ (where your HTML/PHP tools & React build will go)

✅ Requirements
XAMPP

Git (optional, for pulling)

Node.js & npm (for React)

🚀 How to Install & Run
1️⃣ Clone or Pull the Project
bash
Copy
Edit
git clone <your-repo-url>
Or download ZIP & extract.

2️⃣ Move Project to htdocs
Copy the whole project folder (e.g., WEBMISTRY/) to:

makefile
Copy
Edit
C:\xampp\htdocs\
So it becomes:

makefile
Copy
Edit
C:\xampp\htdocs\WEBMISTRY
3️⃣ Start XAMPP
Open XAMPP Control Panel

Start Apache & MySQL

4️⃣ Open in Browser
Visit:

arduino
Copy
Edit
http://localhost/WEBMISTRY/
index.html or default.php will load by default.

✅ Database (if used)
Open phpMyAdmin

Import your .sql file if you have one.

⚛️ How to Add & Run React Tool
Suppose you have a React app for cpc-calculator.

📦 1. Build the React Project
bash
Copy
Edit
cd your-react-app
npm run build
This will generate a /build folder.

📂 2. Place React Build in Tools/
Copy the entire /build folder contents into:

bash
Copy
Edit
WEBMISTRY/Tools/cpc-calculator/
So you’ll have:

swift
Copy
Edit
WEBMISTRY/Tools/cpc-calculator/index.html
WEBMISTRY/Tools/cpc-calculator/static/...
🔗 3. Link React Tool in Your HTML/PHP Project
Example link in nav.html:

html
Copy
Edit
<a href="Tools/cpc-calculator/index.html">CPC Calculator</a>
Or embed inside a PHP page using iframe:

html
Copy
Edit
<iframe src="Tools/cpc-calculator/index.html" width="100%" height="600px"></iframe>
✅ How to Access
Visit:

bash
Copy
Edit
http://localhost/WEBMISTRY/Tools/cpc-calculator/
Your React app will work inside your main project.

✔️ Summary
✅ Pull → htdocs → run with XAMPP

✅ Database via phpMyAdmin if needed

✅ React tool: build → copy → link in HTML/PHP

🗂️ Good Practice
Keep React build separate from your PHP code.

Don’t put React src/ or node_modules/ in htdocs — only build/.

Use Git for version control.

🔗 Useful Commands
Start dev React: npm start

Build React: npm run build

Restart Apache/MySQL if you change configs.
