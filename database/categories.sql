CREATE TABLE categories (
    id         int auto_increment primary key,
    name      varchar(255) null
);

INSERT INTO categories (`name`) VALUES
    ('Delivery'),
    ('Returns & Refunds'),
    ('Order Issues'),
    ('Payment, Promo & Gift Vouchers'),
    ('Technical'),
    ('Product & Stock')
;
