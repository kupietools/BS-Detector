### Documentation: Using the KupieTools Framework to Serve Your Own Single-File PHP App

The KupieTools framework provides a highly portable and self-contained PHP environment, designed for deploying single-file apps with minimal configuration. This documentation explains how to customize the framework for your own use by swapping out the provided code with your own application logic.

---

### **Overview of Framework Features**
1. **Self-contained portability**: All assets (e.g., icons, images, and scripts) are embedded directly in the PHP file.
2. **Bookmarklet support**: Automatically generates a bookmarklet for quick access to your app’s functionality.
3. **Custom URL parameters**: Built-in parameter handling provides flexibility for dynamic interaction with your app.
4. **Utilities for security and portability**:
   - Functions like `makeSafe()` sanitize input to prevent XSS attacks.
   - `curPageURL()` and `curPageURLNoParams()` dynamically adapt to the current hosting environment.
5. **Built-in customization options**: Configurable variables for branding, versioning, and more.

---

### **How to Replace the Existing Application Logic**

#### Follow the steps below to add your own app functionality to the framework:

---

#### **1. Understand the Key Sections of the Code**
The KupieTools framework is divided into logical sections:
- **Standard Functions** (Section I): Utility functions like `makeSafe()`, `queryParameter()`, and `curPageURL()`.
- **URL Parameters** (Section II): Predefined parameters like `c=vh` (version history) or `bs=xxx` (query data).
- **User-Changeable Variables** (Section III): Configurable options for branding (`$user__toolName`), versioning (`$user__versionHistory`), and assets (`$user__favIcon`).
- **Custom Logic Section**: Add your app's custom code here, replacing or extending the existing logic.

---

#### **2. Replace or Extend the `commandParameter()` and `queryParameter()` Logic**
These functions handle URL parameters. Update them to process parameters required by your app.

Example:
```php
// Add a new custom parameter, such as "action=example"
function commandParameter() {
    if (!isset($_GET["c"])) return false;
    return $_GET["c"];
}

function queryParameter() {
    // Example: Return the value of a custom parameter
    if (!isset($_GET["action"])) return "";
    return $_GET["action"];
}
```

---

#### **3. Replace the Main Application Logic**
The main logic is currently split into blocks that handle specific `c` parameters (e.g., `c=vh` for version history). Replace these blocks with your own functionality.

Example:
```php
if (commandParameter() == "mycustomaction") {
    // Your custom logic goes here
    echo "<h1>Welcome to My Custom App</h1>";
    die;
}
```

---

#### **4. Update the Bookmarklet**
The bookmarklet is generated dynamically by embedding the source code of your app into the page. Ensure that your app’s main function is referenced in the `writeAnchor()` function.

Example:
```html
<script>
function writeAnchor(theLabel) {
    var lText = (theLabel === "") ? "Run My App" : theLabel;
    document.write('<a class="bsbutton" href="javascript:(function(){ /* Your app logic here */ })();">' + lText + '</a>');
}
</script>
```

---

#### **5. Update User-Changeable Variables**
Modify these variables to reflect your app’s branding and configuration:
- `$user__toolName`: Full name of your tool.
- `$user__toolShortName`: Short name for references.
- `$user__bookmarkletLabel`: Label for the bookmarklet button.
- `$user__versionHistory`: Add version details for your app.

Example:
```php
$user__toolName = "My Custom PHP App";
$user__toolShortName = "Custom App";
$user__bookmarkletLabel = "Run App";
$user__versionHistory = "
January 20, 2025 - Initial release of My Custom PHP App
";
```

---

#### **6. Add Your Custom JavaScript**
If your app relies on JavaScript, embed it within the `<script>` tags already provided in the framework. You can also add new `<script>` blocks for modularity.

Example:
```html
<script>
function customFunction() {
    alert("This is my custom JavaScript function!");
}
</script>
```

---

#### **7. Replace the UI**
The current framework includes a sample UI for the BS Detector. Modify the HTML structure and CSS as needed to implement your app’s user interface.

Example:
```html
<div id="app">
    <h1>Welcome to My Custom App</h1>
    <form method="GET">
        <label for="input">Enter something:</label>
        <input type="text" id="input" name="customparam">
        <button type="submit">Submit</button>
    </form>
</div>
```

---

#### **8. Test URL Parameter Handling**
The framework supports URL parameters like `?bs=example`. Test your app with custom parameters to ensure dynamic functionality works as expected.

Example:
```php
// Access custom parameters
$myParam = isset($_GET['customparam']) ? $_GET['customparam'] : 'default value';
echo "You entered: " . makeSafe($myParam);
```

---

### **Deployment Steps**
1. **Self-host the PHP file**:
   - Place the modified PHP file on any web server that supports PHP.
2. **Test Bookmarklet Functionality**:
   - Drag the generated bookmarklet to your browser’s bookmarks bar.
   - Confirm that it works as expected on various web pages.
3. **Verify Portability**:
   - Test the app on different hosting environments (e.g., local server, shared hosting, cloud hosting).
4. **Enable Version Updates (Optional)**:
   - To allow users to check for updates, implement the `c=dl` (download) and `c=vh` (version history) parameters. Ensure compatibility with future updates of the framework.

---

### **Conclusion**
The KupieTools framework provides a robust foundation for deploying single-file PHP applications. By following the steps above, you can easily swap the existing functionality with your own custom app logic while preserving the framework’s portability and flexibility.
