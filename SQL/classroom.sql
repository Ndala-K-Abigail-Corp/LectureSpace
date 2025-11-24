USE room;

CREATE TABLE classrooms (
    classroom_id VARCHAR(50) NOT NULL UNIQUE,
    classroom_name VARCHAR(255) NOT NULL,
    classroom_type ENUM('practical', 'theoretical') NOT NULL,
    seating_capacity INT NOT NULL,
    PRIMARY KEY (classroom_id)
);
