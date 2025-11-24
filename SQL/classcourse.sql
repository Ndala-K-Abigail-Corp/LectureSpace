USE room;

DROP TABLE IF EXISTS classcourse;

CREATE TABLE classcourse (
    classcourse_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id VARCHAR(50) NOT NULL,
    classroom_id VARCHAR(50) NOT NULL,
    day ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday') NOT NULL,
    time VARCHAR(50) NOT NULL,
    UNIQUE (course_id, classroom_id, day, time), 
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE,
    FOREIGN KEY (classroom_id) REFERENCES classrooms(classroom_id) ON DELETE CASCADE
);
