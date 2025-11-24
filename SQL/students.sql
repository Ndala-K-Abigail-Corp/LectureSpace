USE room;
CREATE TABLE students (
    user_id INT,
    student_id VARCHAR(50) NOT NULL UNIQUE,
    intake VARCHAR(10),
    PRIMARY KEY (user_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);
