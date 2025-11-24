USE room;
ALTER TABLE users
MODIFY COLUMN user_type ENUM('student', 'lecturer', 'admin') NOT NULL;
