# VulnShop - Vulnerable Web Application for Penetration Testing Training

A deliberately vulnerable web application designed for cybersecurity training and penetration testing practice.

## ⚠️ WARNING

**This application contains intentional security vulnerabilities. NEVER deploy this on a public network or production environment!**

This is for **educational purposes only** and should only be run in isolated, controlled environments.

---

## 🎯 Purpose

VulnShop is designed to help cybersecurity students and professionals practice identifying and exploiting common web application vulnerabilities in a legal, safe environment.

### Vulnerabilities Included:
- SQL Injection (Authentication bypass, Data extraction)
- Cross-Site Scripting (XSS) - Reflected and Stored
- Insecure Direct Object Reference (IDOR)
- Unrestricted File Upload
- Broken Access Control
- Cross-Site Request Forgery (CSRF)
- Information Disclosure
- Weak Authentication
- Security Misconfiguration
- Missing Security Headers

---

## 🚀 Quick Start

### Prerequisites
- Docker
- Docker Compose

### Installation & Running

1. **Extract the zip file:**
```bash
unzip vulnshop.zip
cd vulnshop
```

2. **Start the application:**
```bash
docker-compose up -d
```

3. **Wait for services to initialize** (about 30 seconds for MySQL)

4. **Access the application:**
```
http://localhost:8080
```

### Stopping the Application
```bash
docker-compose down
```

### Cleanup (Remove all data)
```bash
docker-compose down -v
rm -rf app/uploads/*
```

---

## 🔐 Default Credentials

The application comes with pre-configured user accounts:

| Username | Password | Role  |
|----------|----------|-------|
| admin    | admin123 | admin |
| john     | password | user  |
| alice    | 123456   | user  |
| bob      | qwerty   | user  |

---

## 🧪 Testing Environment

### Recommended Tools:
- **Burp Suite Community Edition** - HTTP proxy and web scanner
- **OWASP ZAP** - Web application security scanner
- **SQLMap** - SQL injection tool
- **curl** - Command-line HTTP client
- **Browser DevTools** - Built-in browser tools

### Sample Testing Commands:

**Test SQL Injection:**
```bash
curl -X POST http://localhost:8080/login.php \
  -d "username=admin' OR '1'='1'--&password=anything"
```

**Test XSS:**
```bash
curl "http://localhost:8080/search.php?q=<script>alert('XSS')</script>"
```

**Test IDOR:**
```bash
curl http://localhost:8080/profile.php?id=1
curl http://localhost:8080/profile.php?id=2
```

**Find backup files:**
```bash
curl http://localhost:8080/config.php.bak
```

---

## 📚 Learning Resources

For detailed hints on finding and exploiting vulnerabilities, see **HINTS.md**

### Methodology:
1. **Reconnaissance** - Explore the application, identify functionality
2. **Enumeration** - Map out pages, parameters, and entry points
3. **Vulnerability Identification** - Test for common vulnerabilities
4. **Exploitation** - Demonstrate the security impact
5. **Documentation** - Record findings as you would in a real pentest

---

## 🛠️ Troubleshooting

**Application won't start:**
- Ensure ports 8080 and 3306 are not in use
- Check Docker logs: `docker-compose logs`

**Database connection errors:**
- Wait longer for MySQL to initialize
- Check database container: `docker-compose logs db`

**File upload not working:**
- Ensure uploads directory has proper permissions
- Check: `docker-compose exec web ls -la /var/www/html/uploads`

**Pages showing PHP errors:**
- This is expected behavior in a vulnerable application
- The errors themselves can be information disclosure vulnerabilities

---

## 🔒 Security Considerations

### Never Do This:
- ❌ Deploy on public internet
- ❌ Use on a network with sensitive systems
- ❌ Test on systems you don't own
- ❌ Share publicly accessible instances

### Best Practices:
- ✅ Run in isolated network/VM
- ✅ Use only for authorized training
- ✅ Document findings professionally
- ✅ Learn the remediation methods
- ✅ Destroy environment when done

---

## 📖 OWASP Top 10 Mapping

This application demonstrates vulnerabilities from the OWASP Top 10:

1. **A01:2021 – Broken Access Control** (IDOR, unauthorized access)
2. **A02:2021 – Cryptographic Failures** (plaintext passwords)
3. **A03:2021 – Injection** (SQL injection)
4. **A04:2021 – Insecure Design** (no security controls)
5. **A05:2021 – Security Misconfiguration** (exposed backups, weak configs)
6. **A07:2021 – Identification and Authentication Failures** (weak passwords)
7. **A08:2021 – Software and Data Integrity Failures** (no CSRF protection)

---

## 🎓 Learning Objectives

After completing this lab, you should be able to:
- Identify and exploit SQL injection vulnerabilities
- Understand and demonstrate XSS attacks
- Recognize and exploit broken access controls
- Test for and exploit file upload vulnerabilities
- Understand CSRF and create proof-of-concept attacks
- Recognize information disclosure issues
- Identify security misconfigurations
- Write professional penetration testing reports

---

## 📝 License

This project is for educational purposes only. Use responsibly and ethically.

---

## ⚖️ Legal Disclaimer

The creators of VulnShop are not responsible for any misuse of this application. This tool is intended solely for authorized security testing and educational purposes. Users must comply with all applicable laws and regulations.

**You are responsible for ensuring you have permission to test any systems.**

---

## 📞 Support

For educational purposes, refer to:
- OWASP documentation: https://owasp.org
- Web Security Academy: https://portswigger.net/web-security
- Cybersecurity training platforms: HackTheBox, TryHackMe, PentesterLab

Happy (ethical) hacking! 🎯
