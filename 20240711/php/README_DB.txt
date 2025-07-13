Istruzioni per creare il database e la tabella

Andare in phpmyAdmin e andare nella voce di menu a tab "SQL".

1. Creare il DB

CREATE DATABASE programmiTV

2. Andare nel database appena creato e create la tabella 

CREATE TABLE `serie` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `seasons` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `serie`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `serie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

3. Popolare il DB

INSERT INTO `serie` (`id`, `name`, `seasons`) VALUES
(1, 'Friends', 10),
(2, 'The Big Bang Theory', 12),
(3, 'Dexter', 8),
(5, 'Breaking Bad', 5),
(4, 'How I met your mother', 9);


