CREATE TABLE users (
    id INT AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);
CREATE TABLE courses (
    id INT AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    start_date DATE,
    end_date DATE,
    PRIMARY KEY (id)
);
CREATE TABLE instructors (
    id INT AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    hire_date DATE,
    PRIMARY KEY (id)
);
CREATE TABLE time_off_requests (
    id INT AUTO_INCREMENT,
    instructor_id INT,
    start_date DATE,
    end_date DATE,
    reason TEXT,
    status VARCHAR(20) DEFAULT 'pending',
    PRIMARY KEY (id),
    FOREIGN KEY (instructor_id) REFERENCES instructors(id)
);
CREATE TABLE labs (
    id INT AUTO_INCREMENT,
    course_id INT,
    lab_name VARCHAR(100) NOT NULL,
    description TEXT,
    PRIMARY KEY (id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);
CREATE TABLE students (
    id INT AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    enrollment_date DATE,
    PRIMARY KEY (id)
);
);
CREATE TABLE enrollments (
    id INT AUTO_INCREMENT,
    student_id INT,
    course_id INT,
    enrollment_date DATE,
    PRIMARY KEY (id),
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

CREATE TABLE course_instructors (
    id INT AUTO_INCREMENT,
    course_id INT,
    instructor_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (instructor_id) REFERENCES instructors(id)
);

CREATE TABLE payments (
    id INT AUTO_INCREMENT,
    student_id INT,
    course_id INT,
    amount DECIMAL(10, 2),
    payment_date DATE,
    PRIMARY KEY (id),
    FOREIGN KEY (student_id) REFERENCES students(id)
);