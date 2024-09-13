CREATE TABLE users(
id_user int(5)NOT NULL PRIMARY KEY AUTO_INCREMENT,
username varchar(255)NOT NULL,
password varchar(255)NOT NULL,
email varchar(255)NOT NULL,
fname varchar(255)NOT NULL,
lname varchar(255)NOT NULL,
urole int(5)NOT NULL,
create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE urole (
    id_urole int(5) NOT NULL PRIMARY KEY,
    name_urole varchar(255) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ตารารงครุภัณฑ์
CREATE TABLE equipment (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    purchase_date DATE,
    status int(5)NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ตารางการสถานะครุภัณฑ์
CREATE TABLE status_equipment (
    id_e INT PRIMARY KEY AUTO_INCREMENT,
    name_e VARCHAR(100) NOT NULL  
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `status_equipment`(`id_e`, `name_e`) 
VALUES ('1','ใช้งานอยู่'),('2','ส่งซ่อม'),('3','ปลดระวาง');


-- ตารางการซ่อมบำรุง
CREATE TABLE repair_schedule (
    id INT PRIMARY KEY AUTO_INCREMENT,
    equipment_id INT NOT NULL,
    repair_date DATE NOT NULL,
    status_rs int(5)NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE status_repair_schedule (
    id_rs INT PRIMARY KEY AUTO_INCREMENT,
    name_rs VARCHAR(100) NOT NULL  
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `status_repair_schedule`(`id_rs`, `name_rs`) VALUES ('1','รอดำเนินการ'),('2','กำลังดำเนินการ'),('3','ดำเนินการเสร็จสิ้น');


-- ตารางประวัติการซ่อมครุภัณฑ์
CREATE TABLE repair_history (
    id INT PRIMARY KEY AUTO_INCREMENT,
    equipment_id INT NOT NULL,
    repair_date DATE NOT NULL,
    completed_date DATE,
    details TEXT,
    cost DECIMAL(10,2),
    FOREIGN KEY (equipment_id) REFERENCES equipment(id_e)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ตารางการแจ้งซ่อม

CREATE TABLE repair_requests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    equipment_id INT NOT NULL,
    request_date DATE DEFAULT CURRENT_DATE,
    description TEXT,
    status_rr int(5)NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user),
    FOREIGN KEY (equipment_id) REFERENCES equipment(id),
    FOREIGN KEY (status_rr) REFERENCES status_repair_requests(id_rr)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE status_repair_requests (
    id_rr INT PRIMARY KEY AUTO_INCREMENT,
    name_rr VARCHAR(100) NOT NULL  
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `status_repair_requests`(`id_rr`, `name_rr`) VALUES ('1','รออนุมัติ'),('2','อนุมัติ'),('3','ปฏิเสธ');

