# Installation & Setup Guide

## 🚀 দ্রুত শুরু করুন

### প্রয়োজনীয়তা
- PHP 7.4 বা তার উপরে
- MySQL 5.7 বা তার উপরে  
- Apache/Nginx ওয়েব সার্ভার
- XAMPP, WAMP, বা অন্য কোনো লোকাল সার্ভার পরিবেশ

### ধাপ ১: ডাউনলোড এবং সেটআপ

```bash
# প্রজেক্টটি আপনার ওয়েব রুটে রাখুন
cd C:\xampp\htdocs\  # Windows এর জন্য
# অথবা
cd /var/www/html/    # Linux এর জন্য

# GitHub থেকে ক্লোন করুন (অথবা ম্যানুয়ালি ডাউনলোড করুন)
git clone https://github.com/satishchandraroy91-blip/kirtan-lila-directory.git
cd kirtan-lila-directory
```

### ধাপ ২: ডাটাবেস সেটআপ

1. **phpMyAdmin খুলুন** (সাধারণত: http://localhost/phpmyadmin)

2. **নতুন ডাটাবেস তৈরি করুন**:
   - ডাটাবেস নাম: `kirtan_lila_db`
   - সমস্ত ডিফল্ট সেটিংস রাখুন

3. **database.sql ইমপোর্ট করুন**:
   - phpMyAdmin এ নতুন ডাটাবেসটি নির্বাচন করুন
   - "Import" ট্যাবে ক্লিক করুন
   - `database.sql` ফাইল নির্বাচন করুন
   - "Go" বোতাম দিয়ে চালু করুন

### ধাপ ৩: কনফিগারেশন

`config/database.php` ফাইল এডিট করুন:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');              // আপনার MySQL ইউজার
define('DB_PASS', '');                  // আপনার MySQL পাসওয়ার্ড (XAMPP তে সাধারণত খালি)
define('DB_NAME', 'kirtan_lila_db');
define('BASE_URL', 'http://localhost/kirtan-lila-directory/');
```

### ধাপ ৪: ফোল্ডার পারমিশন

আপলোড ফোল্ডার তৈরি এবং পারমিশন সেট করুন:

```bash
mkdir -p uploads/artists
chmod 755 uploads/artists
```

### ধাপ ৫: ওয়েবসাইট খুলুন

ব্রাউজারে এই লিংকটি খুলুন:

```
http://localhost/kirtan-lila-directory/public/index.php
```

## 🔐 লগইন ক্রেডেনশিয়াল

### এডমিন লগইন
```
URL: http://localhost/kirtan-lila-directory/admin/login.php
ইউজারনেম: admin
পাসওয়ার্ড: admin123
```

### টেস্ট শিল্পী (অপশনাল)
নিজে একটি শিল্পী অ্যাকাউন্ট তৈরি করুন এবং এডমিন দিয়ে অনুমোদন করুন।

## 🛠️ ট্রাবলশুটিং

### সমস্যা: "Connection refused" ত্রুটি

**সমাধান:**
1. MySQL সার্ভার চলছে নিশ্চিত করুন
2. `config/database.php` এ ইউজার নাম এবং পাসওয়ার্ড চেক করুন
3. ডাটাবেস নাম ঠিক আছে কিনা যাচাই করুন

### সমস্যা: ফাইল আপলোড না হওয়া

**সমাধান:**
1. `uploads/` ফোল্ডার আছে কিনা চেক করুন
2. ফোল্ডার পারমিশন 755 এ সেট করুন
3. ব্রাউজারে কনসোল (F12) দেখে ত্রুটি বার্তা চেক করুন

### সমস্যা: পেজ খোলা না হওয়া

**সমাধান:**
1. `BASE_URL` ঠিক কিনা চেক করুন
2. ফাইলের পথ ঠিক আছে ক��না যাচাই করুন
3. Apache রিরাইট মডিউল এনেবল করুন

### সমস্যা: বাংলা টেক্সট দেখা না যাওয়া

**সমাধান:**
1. HTML এ `<meta charset="UTF-8">` আছে কিনা চেক করুন
2. ডাটাবেস চার্সেট `utf8mb4` এ সেট করুন

## 📱 মোবাইল টেস্টিং

1. ব্রাউজারে ডেভলপার টুলস খুলুন (F12)
2. মোবাইল ডিভাইস সিমুলেশন চালু করুন
3. বিভিন্ন স্ক্রিন সাইজে পরীক্ষা করুন

## 🚀 প্রোডাকশনে ডিপ্লয় করা

### গুরুত্বপূর্ণ নিরাপত্তা পদক্ষেপ:

1. **ডিফল্ট পাসওয়ার্ড পরিবর্তন করুন**
   ```php
   // admin table এ এডমিন পাসওয়ার্ড আপডেট করুন
   UPDATE admin SET password = MD5('নতুন_পাসওয়ার্ড') WHERE username = 'admin';
   ```

2. **config/database.php লুকান**
   - `.htaccess` ফাইল তৈরি করুন:
   ```apache
   <Files "database.php">
       Deny from all
   </Files>
   ```

3. **SSL/HTTPS সক্ষম করুন**
   - লাইভ সাইটে সবসময় HTTPS ব্যবহার করুন

4. **ব্যাকআপ নিন**
   - নিয়মিত ডাটাবেস ব্যাকআপ নিন
   - ফাইলগুলির ব্যাকআপ রাখুন

## 📞 সাপোর্ট

যদি সমস্যার সম্মুখীন হন:
- GitHub Issues এ রিপোর্ট করুন
- ইমেইল: info@kirtanlila.com

---

**শুভেচ্ছা! আপনার ওয়েবসাইট এখন সম্পূর্ণ এবং কার্যকর হওয়া উচিত। 🎉**
