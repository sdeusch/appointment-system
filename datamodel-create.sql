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
   patientDOB           date NOT NULL,
   patientGender        varchar(10) NOT NULL,
   patientAddress       varchar(100) NULL,
   patientPhone         varchar(15)  NULL,
   patientEmail         varchar(100) unique NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table  patient 
--

INSERT INTO  patient  (  password ,  patientFirstName ,  patientLastName  ,  patientDOB ,  patientGender ,  patientAddress ,  patientPhone ,  patientEmail ) VALUES
('123', 'Lukas', 'Deusch', '1992-05-17', 'male', 'Hauptstraße 1, Mülln, Salzburg, A-5021', '173567758', 'lukas@gmail.com');



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

???  CREATE sampel therapist data >> 


--
-- Table structure for table  appointment 
--
 

CREATE TABLE IF NOT EXISTS  appointment  (
   id                int AUTO_INCREMENT primary key, 
   patient_id        int not null references patient,
   therapist_id      int not null references therapist,
   start_time        datetime not null,
   end_time          datetime not null,
   confirmed         boolean not null, 
   delivered         boolean not null default false            
);

--
-- Dumping data for table  appointment 
--

INSERT INTO  appointment  ( appId ,  patientIc ,  scheduleId ,  appSymptom ,  appComment ,  status ) VALUES
(86, 920517105553, 40, 'Pening Kepala', 'Bila doktor free?', 'done');

-- --------------------------------------------------------

--
-- Table structure for keeping track of therapists' work schedule
--

CREATE TABLE IF NOT EXISTS  work_schedule  (
   id                int AUTO_INCREMENT primary key, 
   therapist_id      int not null references therapist,
   work_day          date not null,
   start_time        time not null,
   end_time          time not null,
   comment           varchar(200),
   constraint uq_therapist_day_start_time unique (therapist_id, work_day, start_time)
);







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
