# BS-Detector

**The Internet Bad Statements Detector is a self-hosted PHP-based tool to help you fact-check info you find online before you pass it along on social media or elsewhere.**

The BS Detector is designed to aid in online research and to help prevent people from passing along nonsense on the internet, by making it easier to look stuff up on Snopes.com, Politifact, FactCheck.org, and other myth-busting websites all at once.

It works very simply: drag a “Detect BS” button to your bookmarks bar. Then, while you surf the web, you can select text on any web page and click your “Detect BS” bookmark link. This will pop up no-nonsense links from a multitude of sites that tell you if it’s well-known BS (plus offer you some sharing options right from the results popup.)

Interested? Check it out. (Right now the instructions on the BS Detector page are a little wordy. Please read ’em. I’m working on simplifying them.)

I really feel like I’ve done something good for humanity with this. Hopefully more people will start fact-checking Bad Statements themselves and rumors before they post them on Facebook, so people like me don’t have to harsh on them anymore for not checking Snopes first.

As of this writing, the Internet Bad Statements detector is live on the web at https://bsdetector.info

**For webmasters:**

Here’s where it gets neat. KupieTools Bad Statements Detector is *handcrafted artisanal portable code*, including features which I have not yet fully documented, but which allow webmasters to copy and host any tool on their own servers with zero configuration and no futzing around required… one single file serves all necessary scripts and images, allows you to download its php source and repost on your own server, automagically updates its self-contained bookmarklet code to work from wherever you put it, and even provides update alerts when the copy you got it from has been updated to a newer version. [er, that last bit hasn't been implemented yet.] (Below is a documentation section with fairly complete documentation for what's currently available.)

It also provides a plug-and-play framework if you develop your own javascript apps… simply enter your javascript code and HTML pages in a function within the file. It automatically gets deployed as a bookmarklet, with the built-in advantages of absolute portability, update checking, and more. Its complete portability and upstream version checking present a new peer-to-peer model of software distribution.

These features will be activated as soon as I’ve got the code tidy enough that I’m not embarrassed at the thought of someone seeing it.

**Tech Details for Developers:**


For developers looking to understand the technical ingenuity of the Internet BS Detector, this section dives deeper into the codebase, its extensibility, and how it showcases best practices in software design.
#### Fully Self-Contained and Portable

The BS Detector is a single PHP file that packages all necessary scripts, styles, and assets within itself.
* No Dependencies: The tool doesn’t rely on external libraries or resources, making it entirely self-contained.
* Embedded Assets: Images (e.g., favicon, Facebook thumbnail) are encoded in base64 and included directly in the file.
* Dynamic Adaptability: The tool automatically adjusts its functionality and URLs to match the server or environment where it’s hosted.

#### Developer-Friendly Bookmarklet

The bookmarklet is dynamically generated and adapts to the host environment.
* Automatic Updates: The bookmarklet’s code is adjusted automatically to reflect the server where the tool is hosted.
* Portability: Once installed, the bookmarklet works on any webpage without requiring additional setup.

#### URL-Based Control

Developers can interact with the tool programmatically via URL parameters.

Here are some of the supported parameters:

* ?c=is: Generate and serve a custom search engine (OpenSearch plugin).    
* ?c=fbt: Serve the embedded Facebook thumbnail image for sharing.    
* ?c=dl: Download the PHP source code directly from the tool.    
* ?c=vh: Display the version history.    
* ?bs=your-query: Pass a query directly to the tool for immediate results.    

These parameters provide flexibility for testing, debugging, and customizing the tool.    
#### Built-In Helper Functions

The codebase includes several reusable PHP and JavaScript functions to simplify customization:
* PHP Functions    
    * curPageURLNoParams(): Returns the base URL without query parameters.
    * makeSafe($string): Sanitizes a string for safe output, preventing XSS attacks.
    * queryParameter(): Fetches the value of the bs parameter from the URL.

* JavaScript Functions    
    * getParams(): Returns a hash of the current URL parameters.    
    * getQuery(): Extracts the value of the bs parameter from the URL.    

These functions make it easy to extend the tool’s functionality.
#### Security and Best Practices    
* XSS Protection: User inputs and outputs are sanitized using makeSafe().    
* Encapsulation: URL handling is abstracted into helper functions to reduce errors and enhance security.    
* Error Management: PHP error reporting is configured to avoid exposing sensitive server details.    

#### Extensible Framework

The BS Detector is not just a standalone tool—it’s a framework for deploying custom bookmarklets or web utilities.
* Custom Code: Developers can add their own JavaScript, HTML, or PHP functionality directly into the tool.    
* Automatic Integration: Custom functionality is bundled into the existing framework and deployed as part of the bookmarklet.    
* Version Tracking: The tool includes a ?c=vh parameter to display version history, making it easy to track changes and updates.    

#### Novel Software Distribution Model

The BS Detector introduces a unique approach to software distribution:
* Self-Replicating Source: Web Users can download the PHP source code (?c=dl) through the front end and host their own copies.    
* Decentralized Updates: While not yet fully implemented, the tool is designed to notify users of upstream updates, enabling a decentralized network of self-updating instances.    
* Collaborative Customization: By allowing developers to embed their own functionality, the tool encourages experimentation and sharing.    

### Developer Use Cases
**Build Custom Bookmarklets:** Leverage the built-in framework to create and deploy your own bookmarklets, tailored to specific needs or audiences.    
**Host Personalized Versions:** Deploy unique iterations of the BS Detector on your own server, with custom branding or additional features.    
**Learn Best Practices:** Study the tool’s implementation for insights into:    
* Portable software design.    
* Secure PHP and JavaScript coding.    
* Dynamic adaptation to different environments.    
* * *

Internet BS Detector Complete Documentation
==================================

Overview
--------

The **Internet BS Detector** is a lightweight, self-hosted tool designed to help you research and fact-check statements you find online. With the help of a bookmarklet or search box, you can quickly look up selected text or custom queries on reputable fact-checking websites like Snopes, Politifact, and FactCheck.org.

This tool is portable, requiring no complex installation, and includes options for both casual users and developers seeking to customize it.

* * *

For Users
---------

### Key Features

1.  **Fact-Check Statements Instantly:**
    
    *   Highlight any text on a webpage and click the "Detect BS" bookmarklet to find fact-checking resources.
    *   If no text is selected, the tool will prompt you to enter your own query.
2.  **Simple Bookmarklet Integration:**
    
    *   Drag the "Detect BS" button to your bookmarks bar for one-click access anywhere on the internet.
3.  **Browser Integration (Firefox):**
    
    *   Install the BS Detector as a search engine in Firefox via the OpenSearch plugin.
4.  **Sharing Options:**
    
    *   Share your results with others via:
        *   Facebook
        *   Email
        *   Direct URL copying
5.  **Self-Contained and Portable:**
    
    *   The tool is a single PHP file with no external dependencies. It can be hosted on any server.

* * *

### How to Use

#### 1\. Installing the Bookmarklet

*   Visit the BS Detector page.
*   Drag the "Detect BS" button to your browser’s bookmarks bar.

#### 2\. Checking a Statement

*   Highlight text on any webpage.
*   Click the "Detect BS" bookmarklet in your bookmarks bar.
*   Review the search results in a popup or a new window.

#### 3\. Manual Query

*   If no text is selected, the tool will ask you to input your own query.
*   Alternatively, type your query directly in the search box on the BS Detector page.

#### 4\. Sharing Results

*   Use the built-in options to share your findings:
    *   Click "Share on Facebook."
    *   Copy the results URL by clicking the provided text box.
    *   Email the results to a friend.

* * *

For Developers
--------------

This is an overview of the customization and functions of the KupieTools framework that powers the BS Detector. For compete instructions on including your own app code to take advantage of the framework's features, see the included file [HowToCreateYourOwnKupieToolsApp.md](HowToCreateYourOwnKupieToolsApp.md). 

### Features for Customization

1.  **Customizable Framework:**
    
    *   The tool includes several variables for quick modification:
        *   `$user__toolName`: Full name of the tool (e.g., "Internet BS Detector").
        *   `$user__bookmarkletLabel`: Text displayed on the bookmarklet button.
        *   `$user__favIcon`: Base64-encoded favicon.
        *   `$user__facebookThumbnail`: Base64-encoded image for Facebook sharing.
2.  **Built-In PHP Functions:**
    
    *   **`curPageURL()`**: Returns the full URL of the current page (with parameters).
    *   **`curPageURLNoParams()`**: Returns the base URL of the current page (no parameters).
    *   **`makeSafe($string)`**: Sanitizes a string for safe output (XSS prevention).
    *   **`queryParameter()`**: Retrieves the `bs` query parameter from the URL.
    *   **`commandParameter()`**: Retrieves the `c` query parameter from the URL.
3.  **Extensible Bookmarklet Framework:**
    
    *   Developers can add custom JavaScript functionality into the existing framework for their own use cases.
    *   The tool dynamically updates the bookmarklet to match its hosted URL.
4.  **Version History:**
    
    *   The `$user__versionHistory` variable provides a changelog for tracking updates.

* * *

### URL Parameters

In order to serve multiple functions and provide numerous resources from a single hosted file, the file is called with URL parameters appended to indicate what should be produced. 

Parameter | Description | Example Usage
--- | --- | ---
`bs` | The query term to be fact-checked. | `?bs=Bigfoot`
`c=vh` | Displays the version history. | `?c=vh`
`c=fbt` | Outputs the Facebook thumbnail image. | `?c=fbt`
`c=dl` | Triggers a download of the source code for the BS Detector. | `?c=dl`
`c=is` | Generates an OpenSearch plugin for browser integration. | `?c=is`

* * *

### Installation for Webmasters

1.  **Host the File:**
    
    *   Upload the `bsdetector.php` file to your server.
2.  **Access the Tool:**
    
    *   Navigate to the hosted URL (e.g., `https://yourdomain.com/bsdetector.php`).
3.  **Enable Customization:**
    
    *   Modify user-changeable variables (e.g., `$user__toolName`) to customize the tool’s appearance and branding.

* * *

### Known Limitations and To-Dos

1.  **Documentation (`?c=d`):**
    
    *   A query parameter for showing in-app documentation is not yet implemented.
2.  **Version Update Alerts:**
    
    *   While a framework for version alerts exists, it is not fully functional.
3.  **Cross-Browser Compatibility:**
    
    *   Some features (e.g., iFrames) may not work as expected in browsers with strict content restrictions.
4.  **Simplified Instructions:**
    
    *   The instructions on the tool's homepage may be verbose for new users. Future updates aim to simplify them.
5.  **Favicon:**
    
    *   The code allows storing a favicon as a base64-encoded image but serving it has not been implemented yet.

* * *

FAQ
---

### 1\. What is a bookmarklet, and how does it work?

A bookmarklet is a small JavaScript program saved as a browser bookmark. When you click the "Detect BS" bookmarklet, it runs a script that sends the selected text (or a custom query) to the BS Detector, retrieving fact-checking results.

### 2\. Can I use the BS Detector offline?

No, the tool requires an internet connection to fetch results from fact-checking websites.

### 3\. Is the BS Detector free to use?

Yes, the tool is open-source and distributed under the GNU General Public License v3.0.

### 4\. Can I host the BS Detector on my website?

Yes! The tool is designed for portability. Simply upload the PHP file to your server, and it will work out of the box.


# I am
Michael E. Kupietz, software engineering, Certified FileMaker Pro Developer & Full-Stack Web Developer  
https://kupietz.com (Business info)  
https://github.com/kupietools (Free software)  
https://michaelkupietz.com (Personal & creative showcase)  
