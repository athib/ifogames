
-- -----------------------------------------------------
-- FORUM DATA
-- -----------------------------------------------------

USE ifocop_myshop;

INSERT INTO myshop_genre (id_genre, name) VALUES
    (1, 'Action'),
    (2, 'Aventure'),
    (3, 'Combat'),
    (4, 'Plate-formes'),
    (5, 'FPS'),
    (6, 'MMORPG'),
    (7, 'RPG'),
    (8, 'Simulation'),
    (9, 'Sport'),
    (10, 'Stratégie'),
    (11, 'Survival horror'),
    (12, 'Infiltration'),
    (13, 'Course')
;

INSERT INTO myshop_platform (id_platform, short_name, full_name, owner, release_date) VALUES
    (1, 'PS3', 'Playstation 3', 'Sony', '2006-11-11'),
    (2, 'PS4', 'Playstation 4', 'Sony', '2013-11-15'),
    (3, 'One', 'Xbox One', 'Microsoft', '2013-11-22'),
    (4, '360', 'Xbox 360', 'Microsoft', '2005-11-22'),
    (5, 'Wii U', 'Wii U', 'Nintendo', '2012-11-18'),
    (6, 'Mac', 'Macintosh', 'Apple', NULL),
    (7, 'PC', 'PC', NULL, NULL),
    (8, 'Linux', 'Linux', NULL, NULL),
    (9, '3DS', '3DS', 'Nintendo', '2011-02-26')
;


INSERT INTO myshop_editor (id_editor, name, country, year)
VALUES
    (1, 'Activision', 'USA', 1979),
    (2, 'Blizzard', 'USA', 1991),
    (3, 'Capcom', 'Japon', 1983),
    (4, 'CD Projekt', 'Pologne', 1994),
    (5, 'Rockstar Games', 'USA', 1998),
    (6, 'Electronic Arts', 'USA', 1982),
    (7, 'Naughty Dog', 'USA', 1984),
    (8, 'Ubisoft', 'France', 1986),
    (9, 'Nintendo', 'Japon', 1989),
    (10, 'Bandai Namco Games ', 'Japon', 2006),
    (11, 'Square Enix', 'Japon', 1975)
;


INSERT INTO myshop_game (id_game, title, slug, description, id_editor, release_date, price, pegi, pre_order, jacket) VALUES
    (1, 'GTA V', 'gta-v', 'Description de GTA V', 5, '2014-11-18', 59.99, '18', 0, '1_grand-theft-auto-v.png'),
    (2, 'FIFA 16', 'fifa-16', 'Description de FIFA 16', 6, '2015-09-24', 59.99, '3', 0, '2_fifa-16.jpg'),
    (3, 'Overwatch', 'overwatch', 'Description de Overwatch', 2, '2016-05-24', 69.99, '12', 0, '3_overwatch.jpg'),
    (4, 'Uncharted 4 : A Thief\'s End', 'uncharted-4-a-thiefs-end', 'Description de Uncharted 4', 7, '2016-05-10', 69.99, '18', 0, '4_uncharted-4-a-thiefs-end.jpg'),
    (5, 'Assassin\'s Creed Syndicate', 'assassins-creed-syndicate', 'Description de Assassin\'s creed', 8, '2015-10-23', 39.99, '18', 0, '5_assassins-creed-syndicate.jpg'),
    (6, 'Mario Kart 7', 'mario-kart-7', 'Description de Mario Kart', 9, '2011-12-02', 19.99, '3', 0, '6_mario-kart-7.png'),
    (7, 'Dragon Ball Xenoverse 2', 'dragon-ball-xenoverse-2', 'Description de DBZ', 10, '2016-10-28', 69.99, '12', 1, '7_dragon-ball-xenoverse-2.jpg'),
    (8, 'Final Fantasy XV', 'final-fantasy-xv', 'Description de FF15', 11, '2016-09-30', 69.99, '16', 1, '8_final-fantasy-xv.jpg'),
    (9, 'Resident Evil 7 : Biohazard', 'resident-evil-7-biohazard', 'Description de Resident Evil', 3, '2017-01-24', 69.99, '18', 1, '9_resident-evil-7-biohazard.jpg'),
    (10, 'Far Cry Primal', 'far-cry-primal', 'Description de Far Cry', 8, '2016-02-18', 59.99, '18', 0, '10_far-cry-primal.jpg')
;

INSERT INTO myshop_game_has_genre (id_game, id_genre) VALUES
    (1, 1), (1, 5),
    (2, 9),
    (3, 1), (3, 5), (3, 6),
    (4, 1), (4, 2),
    (5, 1), (5, 2), (5, 12),
    (6, 13),
    (7, 3),
    (8, 1), (8, 2), (8, 7),
    (9, 1), (9, 11), (9, 12),
    (10, 1), (10, 2), (10, 5)
;

INSERT INTO myshop_game_has_platform (id_game, id_platform, stock) VALUES
    (1, 1, 3), (1, 2, 10), (1, 3, 12), (1, 7, 8),
    (2, 1, 2), (2, 2, 11), (2, 3, 8), (2, 4, 6), (2, 5, 4), (2, 6, 5), (2, 7, 13),
    (3, 2, 5), (3, 3, 4), (3, 7, 3),
    (4, 2, 8),
    (5, 2, 8), (5, 3, 6), (5, 7, 2),
    (6, 9, 4),
    (7, 2, 0), (7, 3, 0),
    (8, 2, 0), (8, 3, 0),
    (9, 2, 0), (9, 3, 0), (9, 7, 0),
    (10, 2, 7), (10, 3, 8), (10, 6, 5), (10, 7, 2)
;

INSERT INTO myshop_order (id_order, total, created_at, id_member)
VALUES
    (1, 189.97, '2016-08-12 20:32:47', 2),
    (2, 179.97, '2016-08-13 18:09:24', 2)
;

INSERT INTO myshop_order_has_game (id_order, id_game, id_platform)
VALUES
    (1, 1, 2),
    (1, 2, 3),
    (1, 3, 2),
    (2, 4, 2),
    (2, 5, 3),
    (2, 7, 2)
;


INSERT INTO myshop_comment (id_comment, title, content, created_at, updated_at, id_member, id_game) 
VALUES 
    (1, "vulputate mauris sagittis placerat. Cras dictum", "sit amet,  consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien,  gravida non,  sollicitudin a,  malesuada id,  erat. Etiam vestibulum massa", "2015-10-27 20:13:59", "2015-11-06 16:58:14", 8, 8), 
    (2, "id,  ante. Nunc mauris sapien,  cursus", "ac turpis egestas. Fusce aliquet magna a neque. Nullam ut nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam", "2015-08-10 15:57:18", "2017-07-16 05:01:56", 3, 9),
    (3, "mauris. Morbi non sapien molestie orci tincidunt adipiscing. Mauris molestie", "a,  aliquet vel,  vulputate eu,  odio. Phasellus at augue id ante dictum cursus. Nunc mauris elit,  dictum eu,  eleifend nec,  malesuada ut,  sem. Nulla interdum. Curabitur dictum. Phasellus in", "2015-10-19 17:22:21", "2017-05-05 08:02:08", 4, 10),
    (4, "lacus. Quisque", "velit justo nec ante. Maecenas mi felis,  adipiscing fringilla,  porttitor vulputate,  posuere vulputate,  lacus. Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo.", "2015-09-29 01:08:02", "2017-07-03 01:38:08", 5, 5),
    (5, "blandit viverra. Donec tempus,  lorem fringilla ornare placerat, ", "nisi dictum augue malesuada malesuada. Integer id magna et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit,  pretium et,  rutrum non,  hendrerit id,  ante. Nunc mauris sapien,  cursus in,  hendrerit consectetuer, ", "2016-04-28 12:24:51", "2016-09-16 14:22:43", 10, 10),
    (6, "dui. Fusce diam nunc,  ullamcorper eu,  euismod", "augue. Sed molestie. Sed id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora torquent per conubia nostra,  per inceptos hymenaeos. Mauris ut quam vel sapien imperdiet ornare. In faucibus. Morbi vehicula. Pellentesque tincidunt tempus risus.", "2015-09-26 02:07:34", "2017-03-25 12:20:21", 2, 3),
    (7, "Cras dictum ultricies ligula. Nullam enim. Sed", "In lorem. Donec elementum,  lorem ut aliquam iaculis,  lacus pede sagittis augue,  eu tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et netus", "2015-08-03 03:15:57", "2016-12-29 18:19:00", 6, 5),
    (8, "interdum. Sed auctor odio a purus. Duis", "ut,  pharetra sed,  hendrerit a,  arcu. Sed et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio,  auctor vitae,  aliquet nec,  imperdiet nec,  leo. Morbi neque tellus,  imperdiet non,  vestibulum nec,  euismod in,  dolor. Fusce feugiat. Lorem ipsum dolor sit amet,  consectetuer adipiscing elit.", "2015-11-11 04:15:34", "2016-01-25 08:05:35", 12, 8),
    (9, "vel lectus. Cum sociis natoque penatibus et magnis dis parturient", "Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam,  elementum at,  egestas a,  scelerisque sed,  sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, ", "2016-02-04 19:33:32", "2017-07-05 21:44:34", 2, 8),
    (10, "consequat enim diam vel", "congue turpis. In condimentum. Donec at arcu. Vestibulum ante ipsum", "2015-07-29 20:02:14", "2016-12-28 19:04:46", 8, 7),
    (11, "dolor sit", "enim. Suspendisse aliquet,  sem ut cursus luctus,  ipsum leo elementum sem,  vitae aliquam eros turpis non enim. Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent eu nulla at sem molestie sodales. Mauris blandit enim consequat", "2016-01-12 04:11:02", "2015-09-12 16:52:14", 4, 9),
    (12, "Lorem ipsum dolor", "per inceptos hymenaeos. Mauris ut quam vel sapien imperdiet ornare. In faucibus. Morbi vehicula. Pellentesque tincidunt tempus risus. Donec egestas. Duis ac arcu. Nunc mauris. Morbi non sapien molestie orci tincidunt adipiscing. Mauris molestie pharetra nibh. Aliquam ornare,  libero at auctor ullamcorper,  nisl", "2015-12-08 07:51:00", "2017-05-18 05:37:42", 10, 10),
    (13, "sit amet", "adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien,  gravida non,  sollicitudin a,  malesuada id,  erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis", "2016-03-27 03:22:53", "2015-12-24 23:18:09", 12, 6),
    (14, "a,  auctor non,  feugiat nec, ", "eget varius ultrices,  mauris ipsum porta elit,  a feugiat tellus lorem eu metus. In lorem. Donec elementum,  lorem ut aliquam iaculis,  lacus pede sagittis augue,  eu tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et", "2016-06-27 09:47:53", "2015-12-13 15:47:41", 2, 1),
    (15, "at lacus.", "Nulla tincidunt,  neque vitae semper egestas,  urna justo faucibus lectus,  a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit,  pellentesque a,  facilisis non,  bibendum sed,  est. Nunc laoreet lectus quis massa. Mauris vestibulum,  neque", "2016-06-30 09:43:56", "2016-12-14 12:41:41", 10, 10),
    (16, "urna. Vivamus molestie dapibus", "eu enim. Etiam imperdiet dictum magna. Ut tincidunt orci quis lectus. Nullam suscipit,  est ac facilisis facilisis,  magna tellus faucibus leo,  in lobortis tellus justo sit amet nulla. Donec", "2016-01-22 20:34:30", "2015-09-22 14:33:59", 8, 3),
    (17, "Proin ultrices. Duis volutpat nunc sit amet metus. Aliquam erat", "ipsum ac mi eleifend egestas. Sed pharetra,  felis eget varius ultrices,  mauris ipsum porta elit,  a feugiat tellus lorem eu metus. In lorem. Donec elementum,  lorem ut aliquam iaculis,  lacus pede sagittis augue,  eu tempor erat neque non quam. Pellentesque habitant morbi tristique", "2015-10-18 04:24:38", "2016-02-18 18:10:39", 7, 2),
    (18, "diam nunc,  ullamcorper eu,  euismod ac,  fermentum vel, ", "nunc sit amet metus. Aliquam erat volutpat. Nulla facilisis. Suspendisse", "2016-05-15 12:55:02", "2016-06-02 05:28:19", 6, 6),
    (19, "nisi nibh lacinia", "nibh enim,  gravida sit amet,  dapibus id,  blandit at,  nisi. Cum sociis natoque penatibus et magnis dis parturient montes,  nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam gravida molestie arcu. Sed eu nibh vulputate mauris sagittis placerat. Cras dictum ultricies ligula. Nullam enim. Sed nulla ante, ", "2016-01-25 16:15:23", "2017-04-18 06:05:35", 12, 7),
    (20, "id,  libero. Donec", "sem elit,  pharetra ut,  pharetra sed,  hendrerit a,  arcu. Sed et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio,  auctor vitae,  aliquet nec,  imperdiet nec,  leo. Morbi neque tellus,  imperdiet", "2016-02-24 02:21:16", "2016-03-19 11:20:43", 3, 1),
    (21, "vel sapien imperdiet ornare. In faucibus. Morbi vehicula.", "egestas ligula. Nullam feugiat placerat velit. Quisque varius. Nam porttitor scelerisque neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu turpis. Nulla aliquet. Proin velit.", "2015-11-20 10:05:47", "2016-05-09 21:13:21", 9, 6),
    (22, "Suspendisse aliquet,  sem ut cursus luctus,  ipsum leo elementum", "Aenean massa. Integer vitae nibh. Donec est mauris,  rhoncus id,  mollis", "2016-06-10 07:56:39", "2016-09-26 07:21:40", 1, 7),
    (23, "Duis elementum, ", "adipiscing,  enim mi tempor lorem,  eget mollis lectus pede et risus. Quisque libero lacus,  varius et,  euismod et,  commodo at,  libero. Morbi accumsan laoreet ipsum. Curabitur consequat,  lectus sit amet luctus vulputate,  nisi sem semper erat,  in consectetuer ipsum nunc id", "2016-05-18 01:01:24", "2017-05-27 20:46:27", 11, 2),
    (24, "Vivamus nisi. Mauris nulla. Integer urna. Vivamus molestie dapibus", "tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec tempor,  est ac mattis semper,  dui lectus rutrum urna,  nec luctus felis purus ac tellus. Suspendisse sed dolor.", "2016-07-14 14:31:36", "2015-08-22 18:32:13", 5, 9),
    (25, "ut dolor", "parturient montes,  nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam gravida molestie arcu. Sed", "2015-09-03 23:57:02", "2015-12-27 21:06:06", 8, 3),
    (26, "nulla. Integer vulputate, ", "Nam consequat dolor vitae dolor. Donec fringilla. Donec feugiat metus sit amet ante. Vivamus non lorem vitae odio sagittis semper. Nam tempor diam", "2015-08-31 13:33:00", "2017-07-10 11:15:29", 6, 10),
    (27, "Proin non", "Praesent luctus. Curabitur egestas nunc sed libero. Proin sed turpis nec mauris blandit mattis. Cras eget", "2016-02-06 15:35:43", "2017-03-12 15:13:25", 12, 4),
    (28, "placerat,  orci lacus vestibulum", "dictum. Proin eget odio. Aliquam vulputate ullamcorper magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec", "2016-06-19 00:24:43", "2016-11-16 15:56:31", 5, 4),
    (29, "nec,  eleifend non,  dapibus rutrum,  justo. Praesent luctus. Curabitur egestas", "sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris,  aliquam eu,  accumsan sed,  facilisis vitae,  orci. Phasellus dapibus quam quis diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames", "2016-01-20 23:53:34", "2015-08-26 08:19:11", 9, 7),
    (30, "arcu. Aliquam ultrices iaculis odio. Nam interdum enim", "Sed diam lorem,  auctor quis,  tristique ac,  eleifend vitae,  erat. Vivamus nisi. Mauris nulla. Integer urna.", "2015-09-07 02:27:46", "2016-01-25 09:02:57", 5, 8),
    (31, "at fringilla purus mauris a nunc. In at", "nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam gravida molestie arcu. Sed eu nibh vulputate mauris sagittis placerat. Cras dictum ultricies ligula. Nullam enim. Sed nulla ante,  iaculis nec,  eleifend non,  dapibus rutrum,  justo. Praesent luctus. Curabitur egestas nunc sed libero.", "2016-06-03 16:26:52", "2015-08-11 21:20:57", 5, 1),
    (32, "Integer sem", "eu arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus. Nunc lectus pede,  ultrices a,  auctor non,  feugiat nec,  diam. Duis mi enim,  condimentum eget,  volutpat ornare,  facilisis eget,  ipsum. Donec sollicitudin adipiscing ligula. Aenean gravida nunc sed pede. Cum sociis natoque", "2016-04-02 13:30:01", "2016-02-06 03:33:10", 10, 8),
    (33, "arcu. Morbi sit amet massa.", "Phasellus at augue id ante dictum cursus. Nunc mauris elit,  dictum eu,  eleifend nec,  malesuada ut,  sem.", "2016-04-14 23:32:41", "2017-07-05 09:36:14", 5, 10),
    (34, "quam. Pellentesque habitant morbi tristique", "sem magna nec quam. Curabitur vel lectus. Cum sociis natoque penatibus et magnis dis parturient montes,  nascetur ridiculus mus. Donec dignissim magna a tortor. Nunc commodo auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis ultrices. Vivamus rhoncus. Donec", "2015-08-28 00:53:10", "2016-07-12 02:25:44", 10, 6),
    (35, "ornare. In faucibus. Morbi vehicula. Pellentesque", "varius orci,  in consequat enim diam vel arcu. Curabitur ut", "2015-07-30 18:09:06", "2017-02-13 19:55:14", 2, 6),
    (36, "erat. Vivamus nisi. Mauris", "nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci.", "2016-06-17 17:07:43", "2016-09-08 10:26:19", 3, 4),
    (37, "mi lorem,  vehicula et, ", "semper pretium neque. Morbi quis urna. Nunc quis arcu vel quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis. In condimentum. Donec at arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae Donec tincidunt.", "2015-11-27 07:46:50", "2015-12-20 22:55:09", 10, 3),
    (38, "Fusce aliquet magna a neque. Nullam ut nisi", "amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec tempor,  est ac mattis semper,  dui lectus rutrum urna,  nec luctus felis", "2015-09-09 16:35:06", "2016-11-07 03:11:21", 1, 3),
    (39, "neque pellentesque massa lobortis ultrices.", "ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam feugiat placerat velit. Quisque varius. Nam porttitor scelerisque neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu turpis. Nulla aliquet. Proin velit. Sed", "2016-06-25 04:08:10", "2016-06-23 04:52:09", 3, 9),
    (40, "vitae,  posuere", "enim. Sed nulla ante,  iaculis nec,  eleifend non,  dapibus rutrum,  justo. Praesent luctus. Curabitur egestas nunc sed libero. Proin sed turpis nec mauris blandit mattis. Cras eget nisi dictum augue", "2015-12-20 00:50:09", "2017-03-16 09:29:37", 3, 9),
    (41, "eu dolor egestas rhoncus. Proin", "ut mi. Duis risus odio,  auctor vitae,  aliquet nec,  imperdiet nec,  leo. Morbi neque tellus,  imperdiet non,  vestibulum nec,  euismod in,  dolor. Fusce feugiat. Lorem ipsum dolor sit amet,  consectetuer adipiscing elit.", "2015-08-04 11:29:47", "2017-04-26 04:48:00", 1, 6),
    (42, "adipiscing ligula. Aenean gravida", "Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel turpis. Aliquam adipiscing lobortis risus. In mi pede,  nonummy ut,  molestie in,  tempus eu,  ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum", "2016-04-10 23:26:04", "2015-12-05 01:14:58", 7, 8),
    (43, "in,  hendrerit consectetuer,  cursus et,  magna. Praesent", "lorem eu metus. In lorem. Donec elementum,  lorem ut aliquam iaculis,  lacus pede sagittis augue,  eu tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam fringilla cursus", "2015-07-24 18:29:03", "2017-07-15 03:17:02", 9, 7),
    (44, "Integer mollis.", "dui. Cras pellentesque. Sed dictum. Proin eget odio. Aliquam vulputate ullamcorper magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec feugiat metus sit", "2015-09-09 11:54:18", "2016-10-25 08:43:31", 10, 9),
    (45, "lacus. Nulla tincidunt,  neque vitae semper egestas,  urna", "penatibus et magnis dis parturient montes,  nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque ac libero nec ligula consectetuer rhoncus. Nullam velit dui,  semper et,  lacinia vitae,  sodales", "2016-01-31 04:03:52", "2015-10-24 08:38:38", 6, 4),
    (46, "cursus et,  eros. Proin ultrices. Duis volutpat nunc", "Mauris non dui nec urna suscipit nonummy. Fusce fermentum fermentum", "2015-09-18 23:22:33", "2017-02-03 17:39:39", 5, 1),
    (47, "Integer vulputate,  risus", "Cum sociis natoque penatibus et magnis dis parturient montes,  nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam gravida molestie", "2016-01-17 21:32:01", "2016-07-10 14:19:05", 8, 2),
    (48, "dui,  semper et,  lacinia vitae,  sodales at,  velit. Pellentesque ultricies", "risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam,  elementum at,  egestas a,  scelerisque sed,  sapien.", "2016-07-01 10:50:23", "2015-12-19 18:57:52", 6, 6),
    (49, "posuere vulputate,  lacus. Cras interdum. Nunc", "Proin vel arcu eu odio tristique pharetra. Quisque ac libero nec ligula consectetuer rhoncus. Nullam velit dui,  semper et,  lacinia vitae,  sodales at,  velit. Pellentesque ultricies dignissim lacus. Aliquam rutrum lorem ac risus. Morbi metus. Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis aliquet diam.", "2016-02-27 05:53:05", "2015-11-12 15:56:56", 8, 5),
    (50, "quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis.", "sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer", "2016-04-07 07:37:41", "2016-11-07 17:19:11", 5, 1),
    (51, "Donec fringilla.", "nunc id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque ornare tortor at risus. Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt,  nunc ac mattis ornare,  lectus ante dictum mi,  ac", "2015-09-21 18:58:16", "2017-05-14 13:59:34", 6, 4),
    (52, "Integer aliquam adipiscing lacus. Ut nec", "Donec porttitor tellus non magna. Nam ligula elit,  pretium et,  rutrum non,  hendrerit id,  ante. Nunc mauris sapien,  cursus in,  hendrerit consectetuer,  cursus et,  magna. Praesent interdum ligula eu enim. Etiam imperdiet dictum", "2016-06-18 14:13:10", "2017-03-26 10:16:53", 9, 1),
    (53, "risus quis", "dictum magna. Ut tincidunt orci quis lectus. Nullam suscipit,  est ac facilisis facilisis,  magna tellus faucibus leo,  in lobortis tellus justo sit amet nulla. Donec non", "2015-10-19 02:22:19", "2017-04-12 20:36:57", 1, 10),
    (54, "elit. Aliquam auctor,  velit eget", "sit amet,  consectetuer adipiscing elit. Etiam laoreet,  libero et tristique pellentesque,  tellus sem mollis dui,  in sodales elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet,  erat nonummy ultricies ornare,  elit elit fermentum risus,  at fringilla purus mauris a nunc.", "2016-06-14 12:50:48", "2015-08-13 01:02:26", 1, 4),
    (55, "Mauris magna. Duis dignissim tempor arcu. Vestibulum ut", "Vivamus molestie dapibus ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam feugiat placerat velit. Quisque varius. Nam porttitor scelerisque neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada augue ut lacus. Nulla tincidunt,  neque vitae", "2016-07-24 20:57:40", "2015-09-25 02:17:05", 3, 1),
    (56, "lorem vitae odio sagittis", "lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula", "2015-10-17 06:25:04", "2016-07-26 13:21:55", 11, 1),
    (57, "nec enim. Nunc ut erat. Sed nunc", "vel pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue,  elit sed consequat auctor,  nunc nulla vulputate dui,  nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id", "2016-04-15 18:51:51", "2016-11-28 00:59:52", 4, 10),
    (58, "diam eu dolor egestas rhoncus. Proin nisl sem, ", "neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada", "2016-01-09 10:50:19", "2017-01-07 02:17:17", 5, 4),
    (59, "hendrerit consectetuer, ", "sem ut cursus luctus,  ipsum leo elementum sem,  vitae aliquam eros turpis non enim. Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent eu nulla at sem molestie sodales. Mauris blandit enim consequat purus. Maecenas libero est,  congue a,  aliquet vel,  vulputate eu, ", "2015-12-22 03:23:53", "2016-04-13 04:05:38", 3, 3),
    (60, "Donec vitae", "ac risus. Morbi metus. Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis aliquet diam.", "2016-04-11 12:56:35", "2015-11-13 20:29:55", 6, 9),
    (61, "dolor dolor,  tempus non,  lacinia at,  iaculis quis,  pede. Praesent", "lacus,  varius et,  euismod et,  commodo at,  libero. Morbi accumsan laoreet ipsum. Curabitur consequat,  lectus sit amet luctus vulputate,  nisi sem semper erat,  in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum", "2016-07-02 15:14:59", "2016-07-06 07:11:44", 7, 2),
    (62, "diam. Duis mi enim,  condimentum eget,  volutpat ornare,  facilisis", "suscipit,  est ac facilisis facilisis,  magna tellus faucibus leo,  in lobortis tellus justo sit amet nulla. Donec non justo. Proin non massa non ante bibendum ullamcorper. Duis cursus,  diam at pretium aliquet,  metus urna convallis erat,  eget tincidunt dui augue eu tellus. Phasellus elit pede,  malesuada vel,  venenatis vel,  faucibus", "2015-09-03 02:39:51", "2017-06-25 20:13:10", 1, 4),
    (63, "nec tellus. Nunc lectus pede,  ultrices a,  auctor non, ", "Aliquam rutrum lorem ac risus. Morbi metus. Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis aliquet diam. Sed", "2016-07-01 07:20:11", "2016-11-24 18:09:24", 1, 9),
    (64, "sociis natoque", "nunc sed libero. Proin sed turpis nec mauris blandit mattis. Cras eget nisi dictum augue malesuada malesuada. Integer id magna et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus", "2016-05-29 04:04:16", "2016-08-12 19:21:31", 7, 4),
    (65, "Sed nunc est,  mollis non,  cursus non,  egestas a, ", "diam. Sed diam lorem,  auctor quis,  tristique ac,  eleifend vitae,  erat. Vivamus nisi. Mauris nulla. Integer urna. Vivamus molestie dapibus ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam feugiat placerat velit. Quisque varius. Nam porttitor scelerisque neque. Nullam nisl. Maecenas malesuada fringilla est.", "2015-08-01 04:38:53", "2015-07-31 12:38:28", 1, 8),
    (66, "sem ut cursus luctus, ", "risus a ultricies adipiscing,  enim mi tempor lorem,  eget mollis lectus pede et risus. Quisque libero lacus,  varius et,  euismod et,  commodo at,  libero. Morbi accumsan laoreet ipsum. Curabitur consequat,  lectus sit amet luctus", "2016-02-08 12:10:48", "2017-02-18 06:45:55", 10, 6),
    (67, "magna. Praesent interdum ligula eu enim. Etiam imperdiet dictum", "leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit,  pellentesque a,  facilisis non,  bibendum sed,  est. Nunc laoreet lectus quis massa. Mauris vestibulum,  neque", "2016-07-05 01:47:44", "2016-04-25 04:29:30", 11, 9),
    (68, "tincidunt tempus risus.", "dignissim lacus. Aliquam rutrum lorem ac risus. Morbi metus. Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis aliquet diam. Sed diam lorem,  auctor quis,  tristique ac,  eleifend vitae,  erat. Vivamus nisi. Mauris nulla. Integer urna. Vivamus molestie dapibus ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare", "2015-09-11 02:49:51", "2016-08-22 11:31:55", 12, 10),
    (69, "id sapien. Cras dolor", "non,  lacinia at,  iaculis quis,  pede. Praesent eu dui. Cum sociis natoque penatibus et magnis dis parturient montes,  nascetur ridiculus mus. Aenean eget magna. Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec ante blandit viverra. Donec tempus,  lorem fringilla ornare placerat, ", "2015-12-31 07:58:06", "2017-01-15 01:34:11", 12, 7),
    (70, "convallis,  ante lectus convallis est,  vitae sodales nisi magna sed", "nunc risus varius orci,  in consequat enim diam vel arcu. Curabitur ut odio vel est tempor bibendum. Donec felis orci,  adipiscing non,  luctus sit amet,  faucibus ut,  nulla. Cras", "2015-11-18 05:57:59", "2015-10-22 18:02:39", 10, 5),
    (71, "facilisis,  magna", "dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue,  elit sed consequat auctor,  nunc nulla vulputate dui,  nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae", "2016-05-14 15:58:46", "2015-11-30 16:42:55", 12, 9),
    (72, "ultrices. Duis volutpat", "lectus convallis est,  vitae sodales nisi magna sed dui. Fusce aliquam,  enim nec tempus scelerisque,  lorem ipsum sodales purus,  in molestie tortor nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec tempor,  est ac", "2016-06-21 10:19:51", "2016-08-21 12:11:09", 8, 10),
    (73, "montes,  nascetur ridiculus mus. Aenean eget magna. Suspendisse", "magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit,  pretium et,  rutrum non,  hendrerit id,  ante. Nunc mauris sapien,  cursus in,  hendrerit consectetuer,  cursus et,  magna. Praesent interdum ligula", "2016-07-05 02:35:56", "2015-11-29 06:01:47", 10, 7),
    (74, "amet,  consectetuer adipiscing elit. Aliquam auctor,  velit eget laoreet posuere, ", "ac nulla. In tincidunt congue turpis. In condimentum. Donec at arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae Donec tincidunt. Donec vitae erat vel pede", "2015-08-06 05:45:05", "2017-03-27 12:34:14", 9, 1),
    (75, "eu sem. Pellentesque ut", "arcu. Sed eu nibh vulputate mauris sagittis placerat. Cras dictum ultricies ligula. Nullam enim. Sed", "2015-09-29 06:29:29", "2017-05-18 14:56:20", 7, 6),
    (76, "non dui nec urna", "ante bibendum ullamcorper. Duis cursus,  diam at pretium aliquet,  metus urna convallis erat,  eget tincidunt dui augue eu tellus. Phasellus elit pede,  malesuada vel,  venenatis vel,  faucibus id,  libero. Donec consectetuer mauris id sapien. Cras dolor dolor,  tempus non,  lacinia at,  iaculis quis,  pede. Praesent eu dui. Cum sociis natoque", "2016-05-05 09:57:29", "2016-09-11 02:59:46", 9, 7),
    (77, "odio. Etiam ligula tortor, ", "tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam fringilla cursus purus. Nullam scelerisque neque sed sem egestas", "2015-08-13 21:40:57", "2016-03-08 10:38:59", 4, 6),
    (78, "turpis. Nulla aliquet. Proin velit. Sed malesuada", "ac sem ut dolor dapibus gravida. Aliquam tincidunt,  nunc ac mattis ornare,  lectus ante dictum mi,  ac mattis velit justo nec ante. Maecenas mi felis,  adipiscing fringilla,  porttitor vulputate,  posuere vulputate,  lacus. Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non", "2015-08-01 23:36:46", "2015-12-20 09:46:23", 8, 4),
    (79, "quam. Pellentesque habitant morbi tristique", "risus. In mi pede,  nonummy ut,  molestie in,  tempus eu,  ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit", "2016-06-20 09:10:51", "2016-04-27 15:26:25", 2, 8),
    (80, "faucibus. Morbi", "tempus scelerisque,  lorem ipsum sodales purus,  in molestie tortor nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In", "2015-07-19 04:17:05", "2016-08-16 05:19:25", 11, 3),
    (81, "nec,  malesuada", "Fusce diam nunc,  ullamcorper eu,  euismod ac,  fermentum vel,  mauris. Integer sem elit,  pharetra ut,  pharetra sed,  hendrerit a,  arcu. Sed et libero. Proin mi. Aliquam gravida mauris", "2015-08-26 01:19:42", "2015-12-31 09:38:25", 8, 10),
    (82, "dictum mi,  ac mattis velit", "erat nonummy ultricies ornare,  elit elit fermentum risus,  at fringilla purus mauris a", "2016-03-23 17:06:47", "2017-02-03 01:15:58", 7, 1),
    (83, "euismod et,  commodo", "ultricies adipiscing,  enim mi tempor lorem,  eget mollis lectus pede et risus. Quisque libero lacus,  varius et,  euismod et,  commodo at,  libero. Morbi accumsan laoreet ipsum. Curabitur consequat,  lectus sit amet luctus vulputate,  nisi sem semper erat,  in consectetuer ipsum nunc", "2016-07-10 13:34:47", "2017-01-21 18:19:28", 12, 9),
    (84, "Donec sollicitudin adipiscing", "augue porttitor interdum. Sed auctor odio a purus. Duis elementum, ", "2016-02-05 15:19:02", "2017-03-17 15:27:41", 5, 7),
    (85, "vel,  faucibus id,  libero. Donec", "mi lorem,  vehicula et,  rutrum eu,  ultrices sit amet,  risus. Donec nibh enim,  gravida sit amet, ", "2015-08-08 05:50:16", "2016-08-21 22:18:37", 1, 3),
    (86, "rutrum eu,  ultrices sit amet,  risus. Donec nibh enim, ", "Sed eu nibh vulputate mauris sagittis placerat. Cras dictum ultricies ligula. Nullam enim.", "2015-10-14 07:28:23", "2016-01-01 13:09:15", 10, 2),
    (87, "cubilia Curae Donec tincidunt. Donec vitae erat vel pede blandit", "et magnis dis parturient montes,  nascetur ridiculus mus. Donec dignissim magna a tortor. Nunc commodo auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis ultrices. Vivamus", "2016-04-04 09:27:26", "2015-12-03 16:00:04", 2, 3),
    (88, "Nunc sed orci lobortis augue scelerisque mollis.", "vehicula aliquet libero. Integer in magna. Phasellus dolor elit,  pellentesque a,  facilisis non,  bibendum sed,  est. Nunc laoreet lectus quis massa. Mauris vestibulum,  neque sed dictum eleifend,  nunc risus varius orci,  in", "2015-09-23 22:22:58", "2015-09-12 23:54:40", 1, 6),
    (89, "vestibulum massa rutrum magna. Cras convallis convallis dolor.", "magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec feugiat metus sit amet ante. Vivamus non lorem vitae odio sagittis semper. Nam tempor diam dictum sapien. Aenean massa. Integer vitae nibh. Donec", "2015-09-10 20:19:40", "2015-08-12 17:33:52", 1, 9),
    (90, "libero lacus,  varius et,  euismod et,  commodo at,  libero. Morbi", "ultrices,  mauris ipsum porta elit,  a feugiat tellus lorem eu metus. In lorem. Donec elementum,  lorem ut aliquam iaculis,  lacus pede sagittis augue,  eu tempor erat neque", "2016-04-18 19:04:28", "2015-11-16 05:04:21", 8, 6),
    (91, "elit,  dictum eu,  eleifend nec,  malesuada", "Quisque varius. Nam porttitor scelerisque neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada", "2016-02-14 19:03:38", "2017-03-22 04:58:19", 11, 7),
    (92, "mollis. Integer tincidunt aliquam arcu. Aliquam ultrices", "eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit,  pretium et,  rutrum non,  hendrerit id,  ante. Nunc mauris sapien,  cursus in,  hendrerit consectetuer,  cursus et,  magna. Praesent interdum ligula eu enim. Etiam imperdiet dictum magna. Ut tincidunt orci", "2016-04-26 01:00:51", "2015-11-26 20:23:41", 10, 9),
    (93, "orci luctus et ultrices posuere cubilia Curae Donec", "sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel turpis. Aliquam adipiscing lobortis risus. In mi pede,  nonummy ut,  molestie in, ", "2015-12-05 21:56:00", "2017-06-30 00:13:12", 6, 2),
    (94, "blandit enim consequat purus.", "Vestibulum accumsan neque et nunc. Quisque ornare tortor at risus. Nunc ac sem ut dolor dapibus", "2015-10-10 17:33:58", "2017-03-22 01:41:57", 1, 9),
    (95, "sem,  consequat nec,  mollis vitae,  posuere at, ", "pharetra. Quisque ac libero nec ligula consectetuer rhoncus. Nullam velit dui,  semper et,  lacinia vitae,  sodales at,  velit. Pellentesque ultricies dignissim lacus. Aliquam rutrum lorem ac risus. Morbi metus. Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis aliquet diam. Sed diam lorem,  auctor quis,  tristique", "2016-06-19 18:31:07", "2017-06-27 07:05:52", 12, 9),
    (96, "magnis dis", "et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus odio,  auctor vitae,  aliquet nec,  imperdiet nec,  leo. Morbi neque tellus,  imperdiet non,  vestibulum nec,  euismod in,  dolor. Fusce feugiat. Lorem ipsum dolor sit amet, ", "2016-05-29 01:20:47", "2016-02-14 06:32:59", 2, 5),
    (97, "dui. Cum sociis natoque penatibus et", "ac mattis semper,  dui lectus rutrum urna,  nec luctus felis", "2015-11-18 18:05:44", "2015-12-02 14:36:42", 8, 9),
    (98, "amet risus. Donec egestas. Aliquam nec enim. Nunc ut", "interdum. Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem", "2016-04-06 11:01:22", "2015-12-25 22:05:13", 2, 3),
    (99, "arcu. Vivamus sit", "rutrum lorem ac risus. Morbi metus. Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis aliquet diam. Sed diam lorem,  auctor quis,  tristique ac,  eleifend vitae,  erat. Vivamus nisi. Mauris nulla.", "2015-10-18 04:21:23", "2016-09-13 08:26:21", 5, 5),
    (100, "lobortis quam", "mattis velit justo nec ante. Maecenas mi felis,  adipiscing fringilla,  porttitor vulputate,  posuere vulputate,  lacus. Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor,  nonummy ac,  feugiat non,  lobortis quis,  pede.", "2015-08-06 21:26:48", "2017-01-28 10:46:44", 3, 1);