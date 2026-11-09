# 📋 SUBJECTIVE ANSWER EVALUATION SYSTEM
## Complete Project Documentation & Learning Guide

---

## TABLE OF CONTENTS

1. [Project Overview](#1-project-overview)
2. [System Architecture](#2-system-architecture)
3. [Modules & Features](#3-modules--features)
4. [Database Schema](#4-database-schema)
5. [File-by-File Explanation](#5-file-by-file-explanation)
6. [How the System Works (Step-by-Step)](#6-how-the-system-works-step-by-step)
7. [Setup & Installation](#7-setup--installation)
8. [Tech Stack](#8-tech-stack)
9. [Future Enhancements](#9-future-enhancements)
10. [Conclusion](#10-conclusion)
11. [How to Convert to PDF](#11-how-to-convert-to-pdf)

---

## 2. SYSTEM ARCHITECTURE

```
┌─────────────────┐      ┌─────────────────┐
│   TEACHER       │      │    STUDENT      │
│  (Examiner)     │      │   (Examinee)    │
└────────┬────────┘      └────────┬────────┘
         │                        │
         ▼                        ▼
┌─────────────────────────────────────────────┐
│              WEB INTERFACE                  │
│   (HTML, CSS, Bootstrap 5, JavaScript)      │
└─────────────────────────────────────────────┘
         │                        │
         ▼                        ▼
┌─────────────────────────────────────────────┐
│              PHP BACKEND                    │
│  • Authentication                           │
│  • Exam Management                          │
│  • Answer Submission                        │
│  • Mark Generation                          │
│  • Result Viewing                           │
└─────────────────────────────────────────────┘
         │
         ▼
┌─────────────────────────────────────────────┐
│              MYSQL DATABASE                 │
│  evaluation_db                              │
└─────────────────────────────────────────────┘
         │
         ▼
┌─────────────────────────────────────────────┐
│   PYTHON (Optional - Content Similarity)    │
│   content_similarity.py                     │
│   extract_script.py                         │
└─────────────────────────────────────────────┘
```

### Data Flow
1. Teacher logs in → Creates exam → Uploads questions
2. Student logs in → Views available exams → Takes exam → Submits answers
3. Teacher reviews submissions → Evaluates answers → Generates marks
4. Student views marks and feedback

---

## 3. MODULES & FEATURES

### 3.1 Authentication Module
- **Login** — Email/password authentication for teachers and students
- **Registration** — Role-based signup (Teacher = 1, Student = 2)
- **Logout** — Session termination
- **Role-Based Access** — Different dashboards based on user type

### 3.2 Teacher Module
- Dashboard with overview statistics
- Create and manage exams
- Upload/view questions
- View student submissions
- Evaluate subjective answers
- Generate and publish marks

### 3.3 Student Module
- Dashboard showing assigned exams
- Take exams online
- Type and submit subjective answers
- View evaluated marks and feedback

### 3.4 Answer Evaluation Module
- Answer submission handling
- Text extraction from submissions
- Content similarity checking (plagiarism detection)
- Mark entry and calculation

### 3.5 Reporting Module
- View student marks
- View student records
- Online mark viewing
- Result reports

---

## 4. DATABASE SCHEMA

### Database Name: `evaluation_db`

### Tables

#### 4.1 `users` — Stores all registered users
| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK) | Unique user ID |
| name | VARCHAR | Full name |
| email | VARCHAR | Email address (unique) |
| password | VARCHAR | Hashed password |
| type | INT | 1 = Teacher, 2 = Student |
| created_at | DATETIME | Registration timestamp |

#### 4.2 `exams` — Stores exam information
| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK) | Unique exam ID |
| title | VARCHAR | Exam title |
| description | TEXT | Exam description |
| teacher_id | INT (FK) | Reference to users.id |
| created_at | DATETIME | Exam creation time |

#### 4.3 `questions` — Stores exam questions
| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK) | Unique question ID |
| exam_id | INT (FK) | Reference to exams.id |
| question_text | TEXT | The question |
| marks | INT | Marks allocated |
| created_at | DATETIME | Creation time |

#### 4.4 `submissions` — Stores student answer submissions
| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK) | Unique submission ID |
| exam_id | INT (FK) | Reference to exams.id |
| student_id | INT (FK) | Reference to users.id |
| answer_text | TEXT | Student's written answer |
| file_path | VARCHAR | Path to uploaded file (if any) |
| submitted_at | DATETIME | Submission timestamp |
| status | VARCHAR | pending/evaluated |

#### 4.5 `marks` — Stores evaluated marks
| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK) | Unique mark ID |
| submission_id | INT (FK) | Reference to submissions.id |
| marks_obtained | INT | Marks given by teacher |
| total_marks | INT | Maximum possible marks |
| feedback | TEXT | Teacher's comments |
| evaluated_at | DATETIME | Evaluation time |
| evaluated_by | INT (FK) | Reference to users.id (teacher) |

---

## 1. PROJECT OVERVIEW

The **Subjective Answer Evaluation System** is a web-based platform designed to conduct subjective (essay-type) examinations and evaluate students' written answers. Unlike objective exams (multiple choice), subjective answers require human evaluation. This system streamlines the entire process — from exam creation and student submission to answer evaluation, mark generation, and result viewing.

### Key Stakeholders
- **Teacher/Examiner** — Creates exams, uploads questions, evaluates answers, generates marks
- **Student/Examinee** — Takes exams, submits answers, views results

### Core Problem Solved
Traditional subjective evaluation is paper-based, time-consuming, and difficult to manage at scale. This system digitizes the workflow, making it faster, organized, and accessible online.

---

## 5. FILE-BY-FILE EXPLANATION

### 5.1 Configuration & Database

#### `connection.php`
**Purpose:** Establishes connection to the MySQL database.

```php
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'evaluation_db';
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);
```
- Connects to `evaluation_db` on localhost
- Used by all PHP pages that need database access
- Includes error handling for connection failures

### 5.2 Authentication Files

#### `login.html`
**Purpose:** Frontend login and registration page.
- Toggle between Login and Register forms using jQuery
- Registration dropdown: Teacher (1) or Student (2)
- Input fields: Name, Email, Password
- Styled with custom CSS (Poppins font, responsive design)

#### `login.php`
**Purpose:** Handles user login authentication.
- Receives email and password from POST request
- Queries database for matching user
- Creates session on successful login
- Redirects to appropriate dashboard based on user type

#### `register.php`
**Purpose:** Handles new user registration.
- Inserts new user into `users` table
- Validates input data
- Redirects to login after successful registration

#### `logout.php`
**Purpose:** Destroys user session and logs out.
- Calls `session_destroy()`
- Redirects to login page

### 5.3 Teacher Files

#### `teacher-dash.php`
**Purpose:** Teacher's main dashboard.
- Displays overview of exams created
- Navigation to exam management
- Quick statistics and recent activity

#### `online-exam-teacher.php`
**Purpose:** Exam creation and management interface.
- Create new exams
- View existing exams
- Add questions to exams
- Manage exam settings

#### `fetch_question.php`
**Purpose:** Retrieves questions for a specific exam.
- AJAX endpoint called by frontend
- Returns questions in JSON format
- Used when student starts an exam

### 5.4 Student Files

#### `student-dash.php`
**Purpose:** Student's main dashboard.
- Shows available/exams assigned
- Displays upcoming and completed exams
- Quick access to take exams

#### `online-exam-student.php`
**Purpose:** Student exam taking interface.
- Displays exam questions
- Text area for typing answers
- Submit button to finalize answers
- Timer (if applicable)

### 5.5 Answer Handling Files

#### `answer_submit.php`
**Purpose:** Processes student answer submissions.
- Receives answer text and exam/student IDs
- Saves to `submissions` table
- Returns success/error response

#### `add-answer.php` & `add-answer-2.php`
**Purpose:** Answer management for teachers.
- View submitted answers
- Interface for evaluating answers
- May handle file uploads for answer scripts

#### `extract.php` & `extract-2.php`
**Purpose:** Text extraction from answer submissions.
- Extracts text from uploaded files (PDF, images, etc.)
- Prepares answer text for evaluation
- May use OCR or text parsing

### 5.6 Marking & Grading Files

#### `mark-gen.php`
**Purpose:** Mark generation interface.
- Teacher enters marks for each submission
- Calculates total and percentage
- Saves to `marks` table

#### `mark-gen-online.php`
**Purpose:** Online mark processing.
- AJAX endpoint for real-time mark entry
- Updates marks without page reload

#### `view-marks.php` & `view-marks-online.php`
**Purpose:** View evaluated marks.
- Student views their marks and feedback
- Teacher views class results
- Displays marks obtained vs total marks

### 5.7 Student Management Files

#### `view-student.php` & `view-student-online.php`
**Purpose:** Student records and reporting.
- View list of registered students
- View student performance reports
- Filter and search students

### 5.8 Python Files (Content Similarity)

#### `content_similarity.py`
**Purpose:** Plagiarism/similarity detection.
- Compares student answers for similarity
- Uses text comparison algorithms
- Helps detect copied answers

#### `extract_script.py`
**Purpose:** Text extraction support script.
- Assists PHP extraction files
- Processes uploaded answer scripts
- Converts files to readable text

### 5.9 Frontend Assets

#### `index.html`
**Purpose:** Landing page/homepage.
- Welcome message and system description
- Image slider for banners
- Navigation to login
- Bootstrap 5 styling

#### `css/dash-style.css`
**Purpose:** Dashboard-specific styling.
- Custom styles for teacher/student dashboards
- Responsive layouts
- Color scheme and typography

#### `css/style.css`
**Purpose:** General site styling.
- Landing page styles
- Slider animations
- Header/footer styling

#### `images/`
**Purpose:** Static assets.
- Logo images
- Slider banner images
- Icons

---

## 6. HOW THE SYSTEM WORKS (STEP-BY-STEP)

### Step 1: User Registration & Login

```
Student/Teacher visits login.html
        │
        ▼
   Chooses role (Teacher/Student)
        │
        ▼
   Fills registration form (register.php)
        │
        ▼
   Data saved to users table
        │
        ▼
   Logs in (login.php)
        │
        ▼
   Session created → Redirected to role-based dashboard
```

### Step 2: Teacher Creates an Exam

```
Teacher logs in → teacher-dash.php
        │
        ▼
   Clicks "Create Exam" → online-exam-teacher.php
        │
        ▼
   Enters exam title, description
        │
        ▼
   Adds questions (question text, marks)
        │
        ▼
   Exam saved to exams & questions tables
        │
        ▼
   Exam becomes available for students
```

### Step 3: Student Takes an Exam

```
Student logs in → student-dash.php
        │
        ▼
   Views available exams
        │
        ▼
   Clicks "Take Exam" → online-exam-student.php
        │
        ▼
   Questions loaded via fetch_question.php
        │
        ▼
   Student types answers in text areas
        │
        ▼
   Clicks Submit → answer_submit.php
        │
        ▼
   Answer saved to submissions table
        │
        ▼
   Submission status = "pending"
```

### Step 4: Teacher Evaluates Answers

```
Teacher logs in → teacher-dash.php
        │
        ▼
   Views pending submissions
        │
        ▼
   Opens each answer (add-answer.php / extract.php)
        │
        ▼
   Reads student's answer
        │
        ▼
   Enters marks (mark-gen.php)
        │
        ▼
   Adds feedback comments
        │
        ▼
   Marks saved to marks table
        │
        ▼
   Submission status = "evaluated"
```

### Step 5: Student Views Results

```
Student logs in → student-dash.php
        │
        ▼
   Clicks "View Results" → view-marks.php
        │
        ▼
   Displays marks obtained, total marks, percentage
        │
        ▼
   Shows teacher's feedback

---

## 7. SETUP & INSTALLATION

### Prerequisites
- **Web Server:** Apache (XAMPP, WAMP, or LAMP)
- **PHP:** Version 7.0 or higher
- **MySQL:** Version 5.7 or higher
- **Python:** Version 3.x (for content similarity scripts)

### Installation Steps

#### Step 1: Clone/Download the Project
Place all files in your web server root directory.
Example for XAMPP: `C:\xampp\htdocs\evaluation.com\`

#### Step 2: Create the Database
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Create a new database named `evaluation_db`
3. Create the tables as described in Section 4

#### Step 3: Configure Database Connection
Edit `connection.php`:
```php
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'evaluation_db';
```

#### Step 4: Set Folder Permissions
Ensure these folders are writable by the web server:
- `upload/` — For teacher uploads
- `upload-student/` — For student submissions

#### Step 5: Access the System
Open your browser and navigate to:
```
http://localhost/evaluation.com/
```

---

## 8. TECH STACK

| Layer | Technology | Version | Purpose |
|-------|-----------|---------|---------|
| Frontend | HTML5 | - | Page structure |
| Frontend | CSS3 | - | Styling and layout |
| Frontend | Bootstrap 5 | 5.3.2 | Responsive UI framework |
| Frontend | JavaScript/jQuery | - | Interactivity and AJAX |
| Backend | PHP | 7.x/8.x | Server-side logic |
| Database | MySQL/MariaDB | 5.7+ | Data storage |
| Similarity | Python | 3.x | Content similarity checking |
| Server | Apache/Nginx | - | Web server |

---

## 9. FUTURE ENHANCEMENTS

### Immediate Improvements
1. **Password Hashing** — Use `password_hash()` and `password_verify()` for secure password storage
2. **Input Validation** — Add server-side validation for all form inputs
3. **SQL Injection Prevention** — Use prepared statements instead of direct queries
4. **File Upload Security** — Validate file types and sizes for uploads
5. **Session Security** — Add session timeout and CSRF protection

### Advanced Features
1. **PDF Export** — Generate PDF mark sheets and certificates
2. **Email Notifications** — Send exam reminders and result notifications
3. **Auto-Grading** — AI-based initial grading for subjective answers
4. **Timer Enforcement** — Strict exam timer with auto-submission
5. **Dashboard Analytics** — Charts and graphs for class performance
6. **Mobile App** — React Native or Flutter mobile application
7. **Multiple Question Types** — Support for short answer, long answer, case studies

---

## 10. CONCLUSION

The Subjective Answer Evaluation System provides a complete digital solution for managing subjective examinations. It covers the entire lifecycle:

✅ **User Management** — Registration, authentication, role-based access  
✅ **Exam Management** — Creation, scheduling, question management  
✅ **Answer Submission** — Online answer entry and file uploads  
✅ **Evaluation** — Manual marking with feedback  
✅ **Result Processing** — Mark generation and viewing  
✅ **Similarity Checking** — Plagiarism detection via Python  

This system is suitable for schools, colleges, coaching institutes, and any organization conducting subjective assessments. The modular structure makes it easy to extend and customize.

---

## 11. HOW TO CONVERT THIS TO PDF

### Option 1: Using VS Code (Markdown PDF extension)
1. Install the "Markdown PDF" extension in VS Code
2. Open `PROJECT_REPORT.md`
3. Press `Ctrl+Shift+P` → Type "Markdown PDF: Export (pdf)"
4. Save the PDF file

### Option 2: Using Online Converter
1. Copy the content of `PROJECT_REPORT.md`
2. Go to [markdown2pdf.com](https://www.markdown2pdf.com) or similar
3. Paste and convert to PDF

### Option 3: Using Pandoc (Command Line)
```bash
pandoc PROJECT_REPORT.md -o Project_Report.pdf --pdf-engine=xelatex
```

---

## 📁 PROJECT FILE STRUCTURE (FINAL)

```
evaluation.com/
├── .gitignore
├── README.md
├── PROJECT_REPORT.md          ← This documentation
├── connection.php
├── index.html
├── login.html
├── login.php
├── register.php
├── logout.php
├── teacher-dash.php
├── student-dash.php
├── online-exam-teacher.php
├── online-exam-student.php
├── fetch_question.php
├── answer_submit.php
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
├── css/
│   ├── style.css
│   └── dash-style.css
├── images/
│   ├── logo.png
│   ├── slider1.jpg
│   └── slider2.jpg
├── upload/
└── upload-student/
```

---

*Documentation generated for the Subjective Answer Evaluation System — Ready for academic submission and project showcase.*
