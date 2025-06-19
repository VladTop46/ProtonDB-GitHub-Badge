# ProtonDB GitHub Badge

A simple PHP API that generates dynamic GitHub badges showing your ProtonDB reports count in real-time.

## Usage

### In Markdown (README.md)
```markdown
[![ProtonDB Reports](https://api.vladtop46.ru/anything/v1/badges/protondb.php)](https://www.protondb.com/users/609457498)
```

### In HTML
```html
<a href="https://www.protondb.com/users/609457498">
  <img src="https://api.vladtop46.ru/anything/v1/badges/protondb.php" alt="ProtonDB Reports">
</a>
```

## Example

[![ProtonDB Reports](https://api.vladtop46.ru/anything/v1/badges/protondb.php)](https://www.protondb.com/users/609457498)

## Features

- **Real-time updates**: Badge automatically reflects your current ProtonDB reports count
- **Steam logo**: Includes Steam logo for visual consistency
- **Error handling**: Shows "error" badge if API is unavailable
- **Fast response**: Lightweight PHP script with minimal dependencies
- **GitHub integration**: Perfect for README files

## API Details

**Method**: GET

**Response**: HTTP 302 redirect to shields.io badge

**Data Source**: ProtonDB API (`/data/users/by_id/{userId}.json`)

## Error States

If the ProtonDB API is unavailable or returns invalid data, the badge will show:
- **Label**: "ProtonDB reports"
- **Value**: "error"
- **Color**: Light grey

## Technical Implementation

- Written in PHP
- Uses cURL for HTTP requests
- Leverages shields.io for badge generation
- No database required
- Stateless operation

## Self-Hosting

To host your own instance:

1. Clone or download the PHP script
2. Configure `$USER_ID` with your ProtonDB user ID
3. Optionally adjust `$BADGE_COLOR`
4. Deploy to any PHP-enabled web server

```php
$USER_ID = 'your_protondb_user_id';
$BADGE_COLOR = 'red'; // or blue, green, yellow, etc.
```

## ProtonDB User ID

To find your ProtonDB user ID:
1. Visit your ProtonDB profile
2. Look at the URL: `https://www.protondb.com/users/[YOUR_ID]`
3. The number after `/users/` is your user ID

## License

This project is open source and available under the MIT License.