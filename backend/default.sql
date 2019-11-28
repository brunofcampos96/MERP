INSERT INTO specialty(`description`) VALUES('Pedriatria');
INSERT INTO specialty(`description`) VALUES('Ortopedia');
INSERT INTO specialty(`description`) VALUES('Dermatologia');
INSERT INTO specialty(`description`) VALUES('Oftalmologia');

INSERT INTO `user`(`email`, `name`, `password`) VALUES ('bruno@teste.com','Bruno Fernandes Campos','698dc19d489c4e4db73e28a713eab07b')



vendor/bin/doctrine orm:schema-tool:create

vendor/bin/doctrine orm:schema-tool:drop --force