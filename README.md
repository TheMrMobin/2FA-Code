### `README.md` for 2FA Code Generator Project

---

## 📝 **2FA Code Generator**

This is a simple PHP-based 2FA (Two-Factor Authentication) code generator. It generates a time-based one-time password (TOTP) using a secret hash provided via the URL. The code updates every 10 seconds, and users can click on the code to copy it to their clipboard.

---

## 🚀 **Features**

- **Time-Based OTP**: Generates a 2FA code using the TOTP algorithm.
- **Auto-Refresh**: The code updates every 10 seconds.
- **Copy to Clipboard**: Users can click on the code to copy it.
- **Beautiful UI**: Built with **Bootstrap 5** and **FontAwesome** for a clean and modern design.
- **Modal Confirmation**: Shows a modal when the code is successfully copied.
- **Footer**: Includes a simple footer for additional information.

---

## 🔧 **Requirements**

- PHP 7.4 or higher
- Composer (for dependency management)
- Web server (e.g., Apache, Nginx)

---

## 🛠️ **Installation**

1. **Clone the repository**:
   ```bash
   git clone https://github.com/TheMrMobin/2FA-Code.git
   cd 2FA-Code
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Configure the web server**:
   - Ensure the project is accessible via a web server (e.g., Apache or Nginx).
   - If using Apache, make sure `.htaccess` is enabled.

4. **Access the application**:
   - Open your browser and navigate to:
     ```
     https://your-site.com/2FA/?hash=your-secret-hash
     ```
     Replace `your-secret-hash` with your actual secret hash.

---

## 🌐 **URL Format**

The application requires the secret hash to be passed via the URL in the following format:

```
https://your-site.com/2FA/?hash=your-secret-hash
```

- **`your-site.com`**: Your domain or local server address.
- **`2FA`**: The path to the application (can be customized).
- **`hash`**: The query parameter containing the secret hash.

### Example:
```
https://example.com/2FA/?hash=JBSWY3DPEHPK3PXP
```

---

## 🎨 **How It Works**

1. **Generate 2FA Code**:
   - The application uses the `spomky-labs/otphp` library to generate a TOTP code based on the provided hash.
   - The code updates every 10 seconds.

2. **Copy to Clipboard**:
   - Users can click on the displayed code to copy it to their clipboard.
   - A Bootstrap modal confirms that the code has been copied.

3. **Auto-Refresh**:
   - The page automatically refreshes every 10 seconds to display the new code.

4. **Footer**:
   - A simple footer is displayed at the bottom of the page.

---

## 📂 **Project Structure**

```
Get-2FA-Code/
├── vendor/                  # Composer dependencies
├── index.php                # Main application file
├── .htaccess                # Apache URL rewriting rules
├── composer.json            # Composer configuration
├── README.md                # Project documentation
└── assets/                  # Optional: CSS, JS, or images
```

---

## 🛑 **Important Notes**

1. **Secret Hash**:
   - The secret hash must be a valid base32-encoded string (e.g., `JBSWY3DPEHPK3PXP`).
   - Do not expose sensitive hashes in production environments.

2. **Security**:
   - Ensure the application is hosted on a secure server (HTTPS).
   - Avoid passing sensitive information directly in URLs in production.

3. **Customization**:
   - You can customize the UI by modifying the HTML and CSS in `index.php`.
   - Update the footer text or add additional features as needed.



Enjoy generating your 2FA codes! 🔐

[![Stargazers over time](https://starchart.cc/TheMrMobin/2FA-Code.svg?variant=adaptive)](https://starchart.cc/TheMrMobin/2FA-Code)
