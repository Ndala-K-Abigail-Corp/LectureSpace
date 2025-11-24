USE room;

CREATE TABLE courses (
    course_id VARCHAR(50) NOT NULL UNIQUE,
    course_name VARCHAR(255) NOT NULL,
    num_students INT NOT NULL,
    course_type ENUM('practical', 'theoretical') NOT NULL,
    lecturer_id INT NOT NULL,
    student_intake VARCHAR(50) NOT NULL,
    college VARCHAR(50) NOT NULL,
    PRIMARY KEY (course_id),
    FOREIGN KEY (lecturer_id) REFERENCES users(user_id) ON DELETE CASCADE
);
