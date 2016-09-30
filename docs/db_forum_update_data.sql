-- --------------------------------------------------------------------------------
-- UPDATING forum tables with last_post_id, last_thread_id, nb_posts, nb_threads...
-- --------------------------------------------------------------------------------

-- THREAD nb_posts
UPDATE myshop_forum_thread t
SET nb_posts = (
    SELECT COUNT(*) AS nb_posts
    FROM myshop_forum_post
    GROUP BY id_thread
    HAVING id_thread = t.id_thread
);

-- SECTION nb_threads
UPDATE myshop_forum_section s
SET nb_threads = (
    SELECT COUNT(*) AS nb_threads
    FROM myshop_forum_thread
    GROUP BY id_section
    HAVING id_section = s.id_section
);

-- SECTION nb_posts
UPDATE myshop_forum_section s
SET nb_posts = (
    SELECT SUM(nb_posts)
    FROM myshop_forum_thread
    WHERE id_section = s.id_section
);

-- THREAD last_post_id
UPDATE myshop_forum_thread t
SET last_post_id = (
    SELECT id_post
    FROM myshop_forum_post
    WHERE id_thread = t.id_thread
    ORDER BY created_at DESC
    LIMIT 1
);

-- SECTION last_thread_id
UPDATE myshop_forum_section s
SET last_thread_id = (
    SELECT t.id_thread
    FROM myshop_forum_thread t
        INNER JOIN myshop_forum_post p ON t.last_post_id = p.id_post
    WHERE t.id_section = s.id_section
    ORDER BY p.created_at DESC
    LIMIT 1
);


-- THREAD updated_at
UPDATE myshop_forum_thread
SET updated_at = (
    SELECT DATE_SUB(NOW(),INTERVAL RAND()*365 DAY)
);