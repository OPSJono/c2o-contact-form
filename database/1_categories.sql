CREATE TABLE categories (
    id         int auto_increment primary key,
    name      varchar(255) null
) DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO categories (`name`) VALUES
    ('Delivery'),
    ('Returns & Refunds'),
    ('Order Issues'),
    ('Payment, Promo & Gift Vouchers'),
    ('Technical'),
    ('Product & Stock')
;