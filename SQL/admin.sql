USE room;
CREATE TABLE admins (
    user_id INT,
    admin_id VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (user_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);
