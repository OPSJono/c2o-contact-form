CREATE TABLE contact_form
(
    id              int auto_increment primary key,
    category_id     int,
    person_id       int,
    order_number    int,
    comment         mediumtext null,
    CONSTRAINT fk_category_id FOREIGN KEY (category_id) REFERENCES categories(id),
    CONSTRAINT fk_person_id FOREIGN KEY (person_id) REFERENCES persons(id)
) DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;