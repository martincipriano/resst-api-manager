# REST API Manager

REST API Manager is a powerful plugin designed for administrators to gain better control over WordPress REST API endpoints. This plugin provides a simple interface to toggle specific endpoints on or off, offering improved security and customization for your site.

## Features

- View all registered REST API endpoints.
- Prevent unauthorized access to sensitive data by enabling/disabling specific endpoints.

## Why Use REST API Manager?

- **Enhance Security**: Disable unused or vulnerable endpoints.
- **Improve Performance**: Improve performance by reducing REST API traffic.
- **Customization**: Fine-tune API availability to meet the needs of your site or app.

## Installation

### From WordPress Admin:

1. Download the plugin as a `.zip` file.
2. Log in to your WordPress dashboard.
3. Go to **Plugins > Add New**.
4. Click **Upload Plugin** and upload the `.zip` file.
5. Activate the plugin.

### Manual Installation:

1. Clone this repository or download the `.zip` file.
2. Extract the folder into the `/wp-content/plugins/` directory.
3. Log in to your WordPress dashboard, go to **Plugins**, and activate the "REST API Manager."

## Usage

1. Navigate to **REST API Manager** under settings in the WordPress admin menu.
2. View a list of all registered REST API endpoints.
3. Toggle endpoints on or off using the provided interface.
4. Click **Save Settings** to apply your changes.

**Important:**
- Disabling certain endpoints may affect WordPress core features (e.g., Gutenberg) or plugins/themes dependent on the API. Test your site thoroughly after making changes.
