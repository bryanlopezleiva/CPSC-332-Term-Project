CREATE TABLE PROFESSOR 
(
  SSN varchar(11) NOT NULL,
  PFName varchar(50),
  PLName varchar(50),
  SEX enum('M', 'F'),
  SALARY int,
  STREET_ADDRESS varchar(100),
  CITY varchar(100),
  STATE char(2),
  ZIPCODE char(5),
  AREA_CODE varchar(3),
  TELE_NUMBER varchar(7),
  TITLE varchar(75),

  PRIMARY KEY(SSN)
);

CREATE TABLE PROF_DEGREES
(
  SSN varchar(11) NOT NULL,
  DEGREE varchar(50) NOT NULL,

  PRIMARY KEY(SSN, DEGREE),
  FOREIGN KEY(SSN) REFERENCES PROFESSOR(SSN)
);

CREATE TABLE DEPARTMENT
(
  DNumber varchar(10) NOT NULL,
  DName  varchar(75),
  DArea_Code varchar(50),
  DTele_num varchar(75),
  DOffice_Location varchar(50),
  CHAIR_SSN varchar(11),

  PRIMARY KEY(DNumber),
  FOREIGN KEY(CHAIR_SSN) REFERENCES PROFESSOR(SSN)
);

CREATE TABLE COURSE
(
  CNumber varchar(255) NOT NULL,
  CTitle varchar(255),
  TEXTBOOK varchar(255),
  UNITS int,
  COURSE_DEPARTMENT varchar(10),

  PRIMARY KEY(CNumber),
  FOREIGN KEY(COURSE_DEPARTMENT) REFERENCES DEPARTMENT(DNumber)
);

CREATE TABLE PREREQUISITE
(
  PRE_CNum varchar(15) NOT NULL,
  CNum varchar(15),

  PRIMARY KEY(CNum, PRE_CNum),
  FOREIGN KEY(CNum) REFERENCES COURSE(CNumber),
  FOREIGN KEY(PRE_CNum) REFERENCES COURSE(CNumber)
);

CREATE TABLE COURSE_SECTION
(
  CSNum varchar(15) NOT NULL,
  CLASSROOM varchar(50),
  NUMBER_OF_SEAT int,
  BEGIN_TIME varchar(75),
  END_TIME varchar(75),
  Meeting_Days SET('M', 'T', 'W', 'R', 'F', 'S'),
  CNumber varchar(15),
  P_SSN varchar(11),

  PRIMARY KEY(CSNum, CNumber),
  FOREIGN KEY(CNumber) REFERENCES COURSE(CNumber),
  FOREIGN KEY(P_SSN) REFERENCES PROFESSOR(SSN)
);

CREATE TABLE STUDENT
(
  CWID varchar(50) NOT NULL,
  S_FNAME varchar(25),
  S_LNAME varchar(25),
  S_STREET_ADDRESS varchar(50),
  S_CITY varchar(50),
  S_STATE varchar(50),
  S_ZIPCODE varchar(5),
  S_AREA_CODE varchar(3),
  S_TELE_NUM varchar(15),
  MAJOR varchar(10),

  PRIMARY KEY(CWID),
  FOREIGN KEY(MAJOR) REFERENCES DEPARTMENT(DNumber)
);

CREATE TABLE STUDENT_MINOR
(
  CWID varchar(50) NOT NULL,
  Dnumber varchar(10) NOT NULL,

  PRIMARY KEY(CWID, Dnumber),
  FOREIGN KEY(CWID) REFERENCES STUDENT(CWID),
  FOREIGN KEY(Dnumber) REFERENCES DEPARTMENT(DNumber)
);

CREATE TABLE ENROLLMENT
(
  S_CWID varchar(50) NOT NULL,
  CSNum varchar(15) NOT NULL,
  CNum varchar(15) NOT NULL,
  GRADE enum('A','A-','B+','B','B-','C+','C','C-','D+','D','D-','F'),

  PRIMARY KEY(S_CWID, CSNum, CNum),
  FOREIGN KEY(CSNum, CNum) REFERENCES COURSE_SECTION(CSNum, CNumber),
  FOREIGN KEY(S_CWID) REFERENCES STUDENT(CWID),
  FOREIGN KEY(CNum) REFERENCES COURSE(CNumber)
);

INSERT INTO PROFESSOR VALUES
('123-45-6789', 'Joan', 'Jones', 'F', 75000, '456 State Road', 'Pasadena', 'CA', '91253','555', '2210963', 'Professor'),
('098-23-1126', 'Tony', 'Soprano', 'M', 175000, '121 Boss BLVD', 'Lodi', 'NJ', '07644','973', '0031948', 'Assistant'),
('634-98-2058', 'Lea', 'Thomson', 'F', 55000, '8142 Pearl Ave.', 'Long Beach', 'CA', '90813','562', '1394429', 'Professor');

INSERT INTO DEPARTMENT VALUES
('CPSC', 'Computer Science', '657', '8880012', 'CS-522', '123-45-6789'),
('MATH', 'Mathematics', '657', '2325501', 'MH-154', '098-23-1126');

INSERT INTO COURSE VALUES
('CPSC-332', 'File Structure and Databse', 'Intro to Files and Database', 3, 'CPSC'),
('MATH-338', 'Statistics Applied to Natural Sciences','OpenIntro Statistics', 4, 'MATH'),
('CPSC-323', 'Compilers and Languages', 'Intro to Compiler Construction', 3, 'CPSC'),
('CPSC-440', 'Computer System Architecture', 'Operating Systems: Three Easy Pieces', 3, 'CPSC');

INSERT INTO COURSE_SECTION VALUES
('02', '17383', 45, '11:00 AM', '12:25 PM', 'M,W', 'CPSC-332', '123-45-6789'),
('08', '11452', 35, '3:30 PM', '4:45 PM', 'M,W', 'MATH-338', '098-23-1126'),
('05', '13814', 50, '1:00 PM', '2:15 PM', 'T,R', 'CPSC-323', '634-98-2058'),
('01', '13405', 30, '9:00 AM', '10:15 AM', 'M,W', 'CPSC-440', '123-45-6789'),
('04', '10395', 70, '3:00 PM', '5:25 PM', 'S', 'CPSC-323', '634-98-2058'),
('09', '19923', 35, '1:00 PM', '3:15 PM', 'F', 'CPSC-332', '123-45-6789');


INSERT INTO STUDENT VALUES
  ('987654321', 'Chrissy', 'Molti', '256 Lake Road', 'Fontana', 'CA', '00814', '609', '3604115', 'MATH'),
  ('723456089', 'Liam', 'Nguyen', '400 Main St', 'Irvine', 'CA', '92617', '949', '5551234', 'CPSC'),
  ('223344556', 'Sophia', 'Lee', '789 Oak Ave', 'Anaheim', 'CA', '92801', '714', '3216789', 'MATH'),
  ('334455667', 'Aiden', 'Patel', '101 Pine St', 'Fullerton', 'CA', '92831', '657', '4567890', 'CPSC'),
  ('445566778', 'Mia', 'Garcia', '500 Elm St', 'Santa Ana', 'CA', '92701', '714', '5678901', 'MATH'),
  ('556677889', 'Noah', 'Kim', '345 Birch Rd', 'Los Angeles', 'CA', '92821', '562', '6789012', 'CPSC'),
  ('667788990', 'Olivia', 'Lopez', '888 Maple St', 'Pomona', 'CA', '92868', '714', '7890123', 'CPSC');


INSERT INTO ENROLLMENT VALUES
('987654321', '08', 'MATH-338', 'A'),
('987654321', '02', 'CPSC-332', 'B+'),
('987654321', '01', 'CPSC-440', 'A-'),

('723456089', '05', 'CPSC-323', 'B'),
('723456089', '01', 'CPSC-440', 'A'),
('723456089', '09', 'CPSC-332', 'B-'),

('223344556', '08', 'MATH-338', 'A-'),
('223344556', '04', 'CPSC-323', 'C+'),
('223344556', '02', 'CPSC-332', 'B+'),

('334455667', '05', 'CPSC-323', 'A'),
('334455667', '09', 'CPSC-332', 'B'),
('334455667', '01', 'CPSC-440', 'C'),

('445566778', '08', 'MATH-338', 'B'),
('445566778', '04', 'CPSC-323', 'A'),
('445566778', '02', 'CPSC-332', 'C-'),

('556677889', '01', 'CPSC-440', 'A'),
('556677889', '04', 'CPSC-323', 'B+'),
('556677889', '09', 'CPSC-332', 'D'),

('667788990', '05', 'CPSC-323', 'B-'),
('667788990', '08', 'MATH-338', 'F');



-- Sample query
SELECT C.CTitle, CS.CLASSROOM, CS.BEGIN_TIME, CS.END_TIME, CS.Meeting_Days
FROM PROFESSOR P, COURSE C, COURSE_SECTION CS
WHERE P.SSN = '123-45-6789'
  AND P.SSN = CS.P_SSN
  AND C.CNumber = CS.CNumber;

SELECT GRADE, COUNT(*)
FROM ENROLLMENT E, COURSE_SECTION CS, COURSE C
WHERE C.CNumber = 'MATH-338' AND CS.CNumber = C.CNumber 
      AND CS.CSNum = '08' AND E.CNum = 'MATH-338' AND E.CSNum = '08'
GROUP BY GRADE;


-- STUDENTS QUERY
SELECT   CS.CSNum AS Section_Number, CS.CLASSROOM, CS.Meeting_Days, CS.BEGIN_TIME, CS.END_TIME,  COUNT(E.S_CWID) AS Num_Enrolled
FROM COURSE_SECTION CS
JOIN ENROLLMENT E ON CS.CSNum = E.CSNum AND CS.CNumber = E.CNum 
WHERE CS.CNumber = 'MATH-338' 
GROUP BY CS.CSNum, CS.CLASSROOM, CS.Meeting_Days, CS.BEGIN_TIME, CS.END_TIME;


SELECT 
  E.CNum AS Course_Number,
  C.CTitle AS Course_Title,
  E.CSNum AS Section_Number,
  E.Grade
FROM ENROLLMENT E
JOIN COURSE C ON E.CNum = C.CNumber
WHERE E.S_CWID = '987654321';


