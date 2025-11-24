USE room;
CREATE TABLE lecturers (
    user_id INT,
    lecturer_id VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (user_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);
