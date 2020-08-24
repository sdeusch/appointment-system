-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2015 at 01:02 PM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+01:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database:  db_massage 
--

-- --------------------------------------------------------

--
-- Table structure for table  patient 
--

CREATE TABLE IF NOT EXISTS  patient  (
   id                   int AUTO_INCREMENT primary key, 
   password             varchar(20) NOT NULL,
   patientFirstName     varchar(20) NOT NULL,
   patientLastName      varchar(20) NOT NULL,
   patientMaritialStatus  varchar(10) NOT NULL,
   patientDOB           date NOT NULL,
   patientGender        varchar(10) NOT NULL,
   patientAddress       varchar(100) NOT NULL,
   patientPhone         varchar(15) NOT NULL,
   patientEmail         varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table  patient 
--

INSERT INTO  patient  (  password ,  patientFirstName ,  patientLastName ,  patientMaritialStatus ,  patientDOB ,  patientGender ,  patientAddress ,  patientPhone ,  patientEmail ) VALUES
('123', 'Lukas', 'Deusch', 'single', '1992-05-17', 'male', 'Hauptstraße 1, Mülln, Salzburg, A-5021', '173567758', 'lukas@gmail.com');



--
-- Table structure for table therapist
--

CREATE TABLE IF NOT EXISTS  therapist (
   id                   int AUTO_INCREMENT primary key, 
   employeeNum          number(6) not null unique, 
   password             varchar(20) NOT NULL,
   firstName            varchar(20) NOT NULL,
   lastName             varchar(20) NOT NULL,
   jobTitle             varchar(10) NOT NULL,
   dob                  date NOT NULL,
   address              varchar(100) NOT NULL,
   phone                varchar(15) NOT NULL,
   email                varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table  patient 
--

INSERT INTO  patient  (  password ,  patientFirstName ,  patientLastName ,  patientMaritialStatus ,  patientDOB ,  patientGender ,  patientAddress ,  patientPhone ,  patientEmail ) VALUES
('123', 'Lukas', 'Deusch', 'single', '1992-05-17', 'male', 'Hauptstraße 1, Mülln, Salzburg, A-5021', '173567758', 'lukas@gmail.com');








--
-- Table structure for table  appointment 
--
 

CREATE TABLE IF NOT EXISTS  appointment  (
  id          int AUTO_INCREMENT primary key, 
  patient_id  int not null references patient, 
  
   scheduleId  int(10) NOT NULL,

   appSymptom  varchar(100) NOT NULL,
   appComment  varchar(100) NOT NULL,
   status  varchar(10) NOT NULL DEFAULT 'process'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

--
-- Dumping data for table  appointment 
--

INSERT INTO  appointment  ( appId ,  patientIc ,  scheduleId ,  appSymptom ,  appComment ,  status ) VALUES
(86, 920517105553, 40, 'Pening Kepala', 'Bila doktor free?', 'done');

-- --------------------------------------------------------

--
-- Table structure for table  doctor 
--

CREATE TABLE IF NOT EXISTS  doctor  (
   icDoctor  bigint(12) NOT NULL,
   password  varchar(20) NOT NULL,
   doctorId  int(3) NOT NULL,
   doctorFirstName  varchar(50) NOT NULL,
   doctorLastName  varchar(50) NOT NULL,
   doctorAddress  varchar(100) NOT NULL,
   doctorPhone  varchar(15) NOT NULL,
   doctorEmail  varchar(20) NOT NULL,
   doctorDOB  date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table  doctor 
--

INSERT INTO  doctor  ( icDoctor ,  password ,  doctorId ,  doctorFirstName ,  doctorLastName ,  doctorAddress ,  doctorPhone ,  doctorEmail ,  doctorDOB ) VALUES
(123456789, '123', 123, 'Mohd', 'Mazlan', 'kuala lumpur', '0173567758', 'lan.psis@gmail.com', '1990-04-10');

-- --------------------------------------------------------

--
-- Table structure for table  doctorschedule 
--

CREATE TABLE IF NOT EXISTS  doctorschedule  (
 scheduleId  int(11) NOT NULL,
   scheduleDate  date NOT NULL,
   scheduleDay  varchar(15) NOT NULL,
   startTime  time NOT NULL,
   endTime  time NOT NULL,
   bookAvail  varchar(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table  doctorschedule 
--

INSERT INTO  doctorschedule  ( scheduleId ,  scheduleDate ,  scheduleDay ,  startTime ,  endTime ,  bookAvail ) VALUES
(40, '2015-12-13', 'Sunday', '09:00:00', '10:00:00', 'notavail'),
(41, '2015-12-13', 'Sunday', '10:00:00', '11:00:00', 'available'),
(42, '2015-12-13', 'Sunday', '11:00:00', '12:00:00', 'available'),
(43, '2015-12-14', 'Monday', '11:00:00', '12:00:00', 'available'),
(44, '2015-12-13', 'Sunday', '01:00:00', '02:00:00', 'available');

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table  appointment 
--
ALTER TABLE  appointment 
 ADD PRIMARY KEY ( appId ), ADD UNIQUE KEY  scheduleId_2  ( scheduleId ), ADD KEY  patientIc  ( patientIc ), ADD KEY  scheduleId  ( scheduleId );

--
-- Indexes for table  doctor 
--
ALTER TABLE  doctor 
 ADD PRIMARY KEY ( icDoctor );

--
-- Indexes for table  doctorschedule 
--
ALTER TABLE  doctorschedule 
 ADD PRIMARY KEY ( scheduleId );

--
-- Indexes for table  patient 
--
ALTER TABLE  patient 
 ADD PRIMARY KEY ( icPatient );

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table  appointment 
--
ALTER TABLE  appointment 
MODIFY  appId  int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT for table  doctorschedule 
--
ALTER TABLE  doctorschedule 
MODIFY  scheduleId  int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- Constraints for dumped tables
--

--
-- Constraints for table  appointment 
--
ALTER TABLE  appointment 
ADD CONSTRAINT  appointment_ibfk_4  FOREIGN KEY ( patientIc ) REFERENCES  patient  ( icPatient ),
ADD CONSTRAINT  appointment_ibfk_5  FOREIGN KEY ( scheduleId ) REFERENCES  doctorschedule  ( scheduleId );

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
