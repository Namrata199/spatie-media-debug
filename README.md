Laravel Livewire Image Upload using Filament and Spatie Media Library

## Overview

This project is a Laravel-based application leveraging **Livewire**, **Filament**, and **Spatie Media Library** to replicate and analyze issues with image uploads in Livewire forms. The primary focus is on addressing challenges related to pre-filling image data into a Livewire form and ensuring smooth integration with **Spatie Media Library**.

The system highlights the following problem areas:
1. Inconsistent behavior when loading multiple images from the database into a Livewire form.
2. Challenges in maintaining compatibility with the **SpatieMediaLibraryFileUpload** component for handling pre-filled data.
3. Issues with saving newly uploaded images while retaining previously uploaded images.

---

## Features

- **Laravel Livewire**: Demonstrates real-time form interactions and highlights potential issues with dynamic image loading.
- **Filament Forms**: Utilizes `Wizard` and `SpatieMediaLibraryFileUpload` components to replicate multi-step forms and image upload functionalities.
- **Spatie Media Library**: Showcases its powerful media handling while exploring edge cases with Livewire integration.
- **Image Debugging**: A public repository for the community to analyze and contribute solutions for pre-filling image data into Livewire forms.

---

## Tech Stack

- **Laravel**: Backend framework.
- **Livewire**: Frontend interactivity.
- **Filament**: Form building and UI components.
- **Spatie Media Library**: Image uploads and media management.
- **PHP**: Core backend language.
- **MySQL / SQLite**: Database (configurable).
- **MinIO / Local Storage**: For storing images.

---

## Installation

Follow these steps to set up the project locally.

1. **Clone the Repository**

   ```bash
   git clone https://github.com/Namrata199/spatie-media-debug.git
   ```

2. **Install Dependencies**

   Run the following commands to install Composer and NPM dependencies:

   ```bash
   composer install
   npm install
   ```

3. **Set Up Environment**

   Copy `.env.example` and configure your `.env` file:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Update the following keys for media storage:

   ```env
   FILESYSTEM_DISK=local
   FILAMENT_FILESYSTEM_DISK=local
   ```

   Alternatively, configure S3 or MinIO if required.

4. **Run Database Migrations**

   ```bash
   php artisan migrate
   ```

5. **Seed the Database (Optional)**

   ```bash
   php artisan db:seed
   ```

6. **Run the Application**

   Start the development server:

   ```bash
   php artisan serve
   ```

   Open the application at [http://localhost:8000/user-profile](http://localhost:8000/user-profile).

---

## Key Functionalities

### 1. Livewire Component: `UserProfile`
The main class `UserProfile` includes two form steps:

1. **Step 1: Image Upload**  
   Uses the `SpatieMediaLibraryFileUpload` component to:
   - Load existing images for the user.
   - Allow uploading multiple new images.

2. **Step 2: User Info**  
   Basic user details input, such as the user name.

```php
SpatieMediaLibraryFileUpload::make('data.media')
    ->multiple()
    ->getUploadedFileUsing(static function (): ?array {
        $user = User::find(1);
        return $user->getMedia('users')->map(fn ($media) => ['url' => $media->getUrl()])->toArray();
    })
    ->collection('users');
```

### 2. Saving Media Files
The `saveMediaFiles` function ensures that new files are added to the `users` media collection.

```php
if ($file instanceof TemporaryUploadedFile) {
    $user->addMedia($file->getRealPath())->toMediaCollection('users');
}
```

---

## Routes

The project has a single route for accessing the user profile form.

**Route Definition**:

```php
Route::get('/user-profile', UserProfile::class)->name('user.profile');
```

**URL**: [http://localhost:8000/user-profile](http://localhost:8000/user-profile)

---

## Usage

1. **Access the Form**  
   Navigate to `/user-profile` in your browser.

2. **Upload Images**  
   - Existing images are displayed automatically.
   - You can add multiple new images in the **Image** step.

3. **Go to next step**  
   Press next in the wizard, and the images are uploaded using **Spatie Media Library**.

4. **Validation**  
   The form includes validation to ensure only valid images are uploaded.

---

## Debugging

### Issue Solved:
The primary issue resolved by this project is **image loading** in a Livewire component when manually pre-filling the data.

**Key Debugging Techniques**:
- Use `SpatieMediaLibraryFileUpload::getUploadedFileUsing` to retrieve media URLs.
- Transform the data into a compatible array format.
- Manually check `dd()` output to ensure the correct data structure.

---

## Notes

- **Storage Configuration**: Update the `FILESYSTEM_DISK` key in the `.env` file for custom media storage.
- **Image Debugging**: Use `dd($mediaFiles)` to inspect the media URLs being passed.
- **Spatie Media Library**: Ensure the package is installed and configured correctly.

---

## Dependencies

- Laravel 11
- Livewire
- Filament
- Spatie Media Library
- TailwindCSS (for UI)

---

## Contribution

Feel free to fork the repository, create a feature branch, and submit a pull request.

---
