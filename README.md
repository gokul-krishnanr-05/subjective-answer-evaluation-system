# 📚 Subjective Answer Evaluation System

An online platform for conducting subjective exams and evaluating written answers.  
Built with **PHP**, **MySQL**, **HTML/CSS**, and **JavaScript**, with optional Python-based content similarity checking.

## 🗂️ Project Structure

```
evaluation.com/
├── css/                 # Stylesheets
├── images/              # Static assets (logo, banners)
├── upload/              # Teacher uploads
├── upload-student/      # Student submissions
├── connection.php       # Database connection
├── index.html           # Landing page
├── login.html           # Login / Register UI
├── login.php            # Login handler
├── register.php         # Registration handler
├── teacher-dash.php     # Teacher dashboard
├── student-dash.php     # Student dashboard
├── online-exam-teacher.php
├── online-exam-student.php
├── fetch_question.php
├── add-answer.php
├── add-answer-2.php
├── extract.php
├── extract-2.php
├── mark-gen.php
├── mark-gen-online.php
├── view-marks.php
├── view-marks-online.php
├── view-student.php
├── view-student-online.php
├── content_similarity.py
├── extract_script.py
└── README.md
```

## 🚀 Features

- 👨‍🏫 **Teacher Dashboard** — create exams, upload questions, view student submissions, generate marks
- 🎓 **Student Dashboard** — take exams, submit answers, view results
- 🔐 **Authentication** — secure login/registration with role-based access (Teacher/Student)
- 📝 **Subjective Answer Handling** — text extraction, answer storage, marking
- 🔍 **Content Similarity** — optional plagiarism/similarity checking via Python scripts
- 📊 **Mark Generation** — automated and manual mark entry, online/offline views

## 🛠️ Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | PHP 7.x / 8.x |
| Database | MySQL / MariaDB |
| Frontend | HTML5, CSS3, Bootstrap 5, JavaScript |
| Similarity Check | Python |
| Web Server | Apache / Nginx (XAMPP, WAMP, etc.) |

## ⚙️ Installation & Setup

### 1. Clone the repository

```bash
git clone <repository-url>
cd evaluation.com
```

### 2. Configure the database

Create a MySQL database named `evaluation_db` and import the schema (SQL file to be added).

Update `connection.php` with your credentials:

```php
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'evaluation_db';
```

### 3. Deploy on a local server

Place the project in your web server root (e.g., `htdocs` for XAMPP) and access via:

```
http://localhost/evaluation.com/
```

### 4. Set upload directory permissions

Ensure `upload/` and `upload-student/` are writable by the web server so file submissions work correctly.

## 📄 License

This project is developed for educational/evaluation purposes. See `LICENSE` for details.

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/your-feature`)
3. Commit your changes (`git commit -m "Add: ..."`)
4. Push to the branch (`git push origin feature/your-feature`)
5. Open a Pull Request

## 👥 Authors

- Your Name — Initial work