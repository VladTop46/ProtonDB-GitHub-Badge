# ProtonDB GitHub Badge

A simple PHP API that generates dynamic GitHub badges showing your ProtonDB reports count in real-time.

## Public API

**Free to use!** This API is publicly available for anyone. Just replace `YOUR_USER_ID` with your ProtonDB user ID in the examples below.

## Usage

### In Markdown (README.md)
```markdown
[![ProtonDB Reports](https://api.vladtop46.ru/anything/v1/badges/protondb.php?id=YOUR_USER_ID)](https://www.protondb.com/users/YOUR_USER_ID)
```

### In HTML
```html
<a href="https://www.protondb.com/users/YOUR_USER_ID">
  <img src="https://api.vladtop46.ru/anything/v1/badges/protondb.php?id=YOUR_USER_ID" alt="ProtonDB Reports">
</a>
```

### Real Example

```markdown
[![ProtonDB Reports](https://api.vladtop46.ru/anything/v1/badges/protondb.php?id=609457498)](https://www.protondb.com/users/609457498)
```

## Live Demo

[![ProtonDB Reports](https://api.vladtop46.ru/anything/v1/badges/protondb.php?id=609457498)](https://www.protondb.com/users/609457498)

## API Parameters

**Endpoint**: `https://api.vladtop46.ru/anything/v1/badges/protondb.php`

**Method**: GET

**Parameters**:
- `id` (required): Your ProtonDB user ID

**Response**: HTTP 302 redirect to shields.io badge

**Example**: `?id=609457498`

## Features

- **Real-time updates**: Badge automatically reflects your current ProtonDB reports count
- **Steam logo**: Includes Steam logo for visual consistency
- **Error handling**: Shows "error" badge if API is unavailable or ID is invalid
- **Fast response**: Lightweight PHP script with minimal dependencies
- **GitHub integration**: Perfect for README files
- **Public API**: Free to use for everyone
- **Input validation**: Validates user ID format

## Error States

The badge will show different error states:

- **Invalid ID**: "invalid ID" (red badge) - when non-numeric ID is provided
- **API Error**: "error" (light grey badge) - when ProtonDB API is unavailable
- **Missing ID**: Uses default ID or shows error if configured to require ID

## ProtonDB User ID

To find your ProtonDB user ID:

1. Visit your ProtonDB profile
2. Look at the URL: `https://www.protondb.com/users/[YOUR_ID]`
3. The number after `/users/` is your user ID
4. Use this number in the `id` parameter

**Example**: If your profile URL is `https://www.protondb.com/users/123456789`, your user ID is `123456789`.

## Technical Implementation

- Written in PHP
- Uses cURL for HTTP requests
- Leverages shields.io for badge generation
- Input validation for security
- No database required
- Stateless operation

## Self-Hosting

To host your own instance:

1. Clone or download the PHP script
2. Deploy to any PHP-enabled web server
3. Optionally configure default user ID and badge color in the script

```php
$DEFAULT_USER_ID = 'your_default_id'; // fallback if no ID provided
$BADGE_COLOR = 'red'; // or blue, green, yellow, etc.
```

No additional configuration needed - users can pass their ID via the `?id=` parameter!

## Rate Limiting

Please be considerate when using the public API:
- Don't make excessive requests
- For high-traffic usage, consider self-hosting

## Contributing

This project is open source. Feel free to:
- Report issues
- Submit improvements
- Host your own instance
- Share with the community

## License

This project is open source and available under the MIT License.