USE room;
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    salutation VARCHAR(10),
    email VARCHAR(255) UNIQUE NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,  
    user_type ENUM('student', 'lecturer') NOT NULL,
    college VARCHAR(50)
);

