create DATABASE tutorialCRUD;

use tutorialCRUD;

create TABLE users
(
    nick varchar (15),
    email varchar (100),
    PRIMARY key (nick, email)
);