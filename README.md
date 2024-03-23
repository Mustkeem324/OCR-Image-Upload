# OCR Image Upload by NC

This is a simple web application that allows users to upload images and perform Optical Character Recognition (OCR) on them. The OCR functionality is powered by the OCR.Space API.

## Features

- **Image Upload**: Users can select an image file from their device and upload it.
- **OCR**: Once an image is uploaded, the application performs OCR to extract text from the image.
- **Supported Formats**: Supported image formats include JPG, JPEG, PNG, and GIF.
- **Error Handling**: The application provides error messages for invalid file types, large file sizes, and failed uploads.
- **Responsive Design**: The application is designed to be responsive and work well on different screen sizes.

## Usage

1. **Upload Image**: Click on the "Select image to upload" button, choose an image file from your device, and click "Upload Image".
2. **OCR Result**: After the upload is completed, the application will display the OCR result if successful.
3. **View Text**: The extracted text will be displayed in a scrollable box, allowing users to view the entire text.

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/your/repository.git
   ```

2. Upload the files to your web server.

3. Ensure that PHP is installed on your server.

4. Sign up for an account on [OCR.Space](https://ocr.space/) to obtain an API key.

5. Update the `apikey` value in the PHP script (`index.php`) with your API key.

6. Ensure that the `uploads` directory has appropriate permissions for file uploads.

7. Access the application through your web browser.

## Customization

- **Background Image**: You can replace the background image by modifying the CSS in the `<style>` section of the HTML (`index.php`).
- **Styling**: Customize the styles (fonts, colors, sizes) by modifying the CSS.
- **API**: If you prefer using a different OCR API, you can modify the `OCRtranslate` function to integrate with another service.

## Dependencies

- [OCR.Space API](https://ocr.space/) - Used for performing OCR on uploaded images.

## Credits

This application was created by [Your Name].

## License

This project is licensed under the [MIT License](LICENSE).
