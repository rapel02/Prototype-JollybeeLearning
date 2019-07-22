-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2018 at 01:35 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jollybeelearningdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `name`, `filename`, `created_at`, `updated_at`) VALUES
(2, 'sagiri', '1530119285sagiri.png', '2018-06-27 10:08:06', '2018-06-27 10:08:06'),
(3, 'takagi', '1530119533takagi.png', '2018-06-27 10:12:13', '2018-06-27 10:12:13'),
(5, 'maki', '1530119976maki.jpg', '2018-06-27 10:19:36', '2018-06-27 10:19:36');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(10) UNSIGNED NOT NULL,
  `difficulty` int(11) NOT NULL,
  `content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `difficulty`, `content`, `created_at`, `updated_at`, `title`, `slug`) VALUES
(1, 18, '<h2>Pre Requisites</h2>\r\n\r\n<p>Binary Search &mdash; How it works and where can it be applied!</p>\r\n\r\n<h2>Motivation Problem</h2>\r\n\r\n<p>We aim to solve this problem :&nbsp;<a href=\"http://www.spoj.com/problems/METEORS/\">Meteors</a></p>\r\n\r\n<p>The question simply states :</p>\r\n\r\n<p>There are&nbsp;<em>N</em>&nbsp;member states and&nbsp;<em>M</em>&nbsp;sectors. Each sector is owned by a member state. There are&nbsp;<em>Q</em>&nbsp;queries, each of which denote the amount of meteor shower in a&nbsp;[<em>L</em>,&thinsp;<em>R</em>]&nbsp;range of sectors on that day. The&nbsp;<em>i</em><em>th</em>&nbsp;member state wants to collect&nbsp;<em>reqd</em>[<em>i</em>]&nbsp;meteors over all its sectors. For every member state, what is the minimum number of days it would have to wait to collect atleast the required amount of meteors?</p>\r\n\r\n<h2>Solution</h2>\r\n\r\n<p>The naive solution here is to do a binary search for each of the&nbsp;<em>N</em>&nbsp;member states. We can update in a range using segment trees with lazy propagation for each query. The time complexity of such a solution would be&nbsp;<em>O</em>(<em>N</em>&thinsp;*&thinsp;<em>logQ</em>&thinsp;*&thinsp;<em>Q</em>&thinsp;*&thinsp;<em>logM</em>). But this one will easily TLE.</p>\r\n\r\n<p>Let&#39;s see if there&#39;s something we are overdoing. For every member state, the binary search applies all the queries until a point multiple times! For example, the first value of&nbsp;<em>mid</em>&nbsp;in the binary search is same for all member states, but we are unnecessarily applying this update everytime, instead of somehow caching it.</p>\r\n\r\n<p>Let&#39;s do all of these&nbsp;<em>N</em>&nbsp;binary searches in a slightly different fashion. Suppose, in every step we group member states by the range of their binary search. In the first step, all member states lie in range&nbsp;[1,&thinsp;<em>Q</em>]. In the second step, some lie in range&nbsp;[1,&thinsp;<em>Q</em>&thinsp;/&thinsp;2]&nbsp;while some lie in range&nbsp;[<em>Q</em>&thinsp;/&thinsp;2,&thinsp;<em>Q</em>]&nbsp;depending on whether the binary search predicate is satisfied. In the third step, the ranges would be&nbsp;[1,&thinsp;<em>Q</em>&thinsp;/&thinsp;4],&nbsp;[<em>Q</em>&thinsp;/&thinsp;4,&thinsp;<em>Q</em>&thinsp;/&thinsp;2],&nbsp;[<em>Q</em>&thinsp;/&thinsp;2,&thinsp;3<em>Q</em>&thinsp;/&thinsp;4],&nbsp;[3<em>Q</em>&thinsp;/&thinsp;4,&thinsp;<em>Q</em>]. So after&nbsp;<em>logQ</em>&nbsp;steps, every range is a single point, denoting the answer for that member state. Also, for each step running the simulation of all&nbsp;<em>Q</em>&nbsp;queries once is sufficient since it can cater to all the member states. This is pretty effective as we can get our answer in&nbsp;<em>Q</em>&thinsp;*&thinsp;<em>logQ</em>&nbsp;simulations rather than&nbsp;<em>N</em>&thinsp;*&thinsp;<em>Q</em>&thinsp;*&thinsp;<em>logQ</em>&nbsp;simulations. Since each simulation is effectively&nbsp;<em>O</em>(<em>logM</em>), we can now solve this problem in&nbsp;<em>O</em>(<em>Q</em>&thinsp;*&thinsp;<em>logQ</em>&thinsp;*&thinsp;<em>logM</em>).</p>\r\n\r\n<p>&quot;A cool way to visualize this is to think of a binary search tree. Suppose we are doing standard binary search, and we reject the right interval &mdash; this can be thought of as moving left in the tree. Similarly, if we reject the left interval, we are moving right in the tree.</p>\r\n\r\n<p>So what Parallel Binary Search does is move one step down in&nbsp;<em>N</em>&nbsp;binary search trees simultaneously in one &quot;sweep&quot;, taking&nbsp;<em>O</em>(<em>N</em>&thinsp;&thinsp;*&thinsp;&thinsp;<em>X</em>)time, where&nbsp;<em>X</em>&nbsp;is dependent on the problem and the data structures used in it. Since the height of each tree is&nbsp;<em>LogN</em>, the complexity is&nbsp;<em>O</em>(<em>N</em>&thinsp;&thinsp;*&thinsp;&thinsp;<em>X</em>&thinsp;&thinsp;*&thinsp;&thinsp;<em>logN</em>).&quot; &mdash;&nbsp;<a href=\"https://codeforces.com/profile/rekt_n00b\">rekt_n00b</a></p>\r\n\r\n<h2>Implementation</h2>\r\n\r\n<p>We would need the following data structures in our implementation :</p>\r\n\r\n<ol>\r\n	<li>linked list for every member state, denoting the sectors he owns.</li>\r\n	<li>arrays&nbsp;<em>L</em>&nbsp;and&nbsp;<em>R</em>&nbsp;denoting range of binary search for each member state.</li>\r\n	<li>range update and query structure for&nbsp;<em>Q</em>&nbsp;queries.</li>\r\n	<li>linked list&nbsp;<em>check</em>&nbsp;for each&nbsp;<em>mid</em>&nbsp;value of current ranges of binary search. For every&nbsp;<em>mid</em>&nbsp;value, store the member states that need to be checked.</li>\r\n</ol>\r\n\r\n<p>The implementation is actually pretty straight forward once you get the idea. For every step in the simulation, we do the following :</p>\r\n\r\n<ol>\r\n	<li>Clear range tree, and update the linked lists for&nbsp;<em>mid</em>&nbsp;values.</li>\r\n	<li>Run every query sequentially and check if the linked list for this query is empty or not. If not, check for the member states in the linked list and update their binary search interval accordingly.</li>\r\n</ol>\r\n\r\n<h2>Pseudo Code</h2>\r\n\r\n<pre>\r\n<code>for all logQ steps:\r\n    clear range tree and linked list check\r\n    for all member states i:\r\n        if L[i] != R[i]:\r\n            mid = (L[i] + R[i]) / 2\r\n            insert i in check[mid]\r\n    for all queries q:\r\n        apply(q)\r\n        for all member states m in check[q]:\r\n            if m has requirements fulfilled:\r\n                R[m] = q\r\n            else:\r\n                L[m] = q + 1</code></pre>\r\n\r\n<p>In this code, the&nbsp;<em>apply</em>()&nbsp;function applies the current update, i.e. , it executes the range update on segment tree. Also to check if the requirements are fulfilled, one needs to traverse over all the sectors owner by that member state and find out the sum. In case you still have doubts, go over to the next section and see my code for this problem.</p>\r\n\r\n<h2>Problems to try</h2>\r\n\r\n<ol>\r\n	<li><a href=\"http://www.spoj.com/problems/METEORS/\">Meteors</a>&nbsp;&mdash;&nbsp;<a href=\"http://ideone.com/tTO9bD\">My AC Solution</a></li>\r\n	<li><a href=\"https://www.hackerearth.com/may-circuits/algorithm/make-n00b_land-great-again-circuits/\">Make n00b land great again</a></li>\r\n	<li><a href=\"https://www.hackerrank.com/contests/may-world-codesprint/challenges/davaro-and-travelling\">Travel in HackerLand</a></li>\r\n	<li><a href=\"http://community.topcoder.com/stat?c=problem_statement&amp;pm=14088\">SRM 675 Div1 500</a></li>\r\n</ol>\r\n\r\n<h2>Conclusion</h2>\r\n\r\n<p>I heard about this topic pretty recently, but was unable to find any good tutorial. I picked up this trick from some comments on codeforces blog on Meteors problem. Alternate solutions to the mentioned problems are also welcome, almost every question on parallel binary search can also be solved with some persistent data structure, unless there is a memory constraint. Feel free to point out errors, or make this tutorial better in any way!</p>\r\n\r\n<p><strong>Happy Coding!</strong></p>', '2018-07-02 00:10:28', '2018-07-02 00:10:28', 'Parallel Binary Search', 'parallel-binary-search'),
(3, 2, '<p>Binary search is an efficient algorithm for finding an item from a sorted list of items. It works by repeatedly dividing in half the portion of the list that could contain the item, until you&#39;ve narrowed down the possible locations to just one. We used binary search in the&nbsp;<a href=\"https://www.khanacademy.org/computing/computer-science/algorithms/intro-to-algorithms/a/a-guessing-game\">guessing game</a>&nbsp;in the introductory tutorial.</p>\r\n\r\n<p>One of the most common ways to use binary search is to find an item in an array. For example, the Tycho-2 star catalog contains information about the brightest 2,539,913 stars in our galaxy. Suppose that you want to search the catalog for a particular star, based on the star&#39;s name. If the program examined every star in the star catalog in order starting with the first,&nbsp;an algorithm called&nbsp;<strong>linear search</strong>, the computer might have to examine all 2,539,913 stars to find the star you were looking for, in the worst case. If the catalog were sorted alphabetically by star names,&nbsp;<strong>binary search</strong>&nbsp;would not have to examine more than 22 stars, even in the worst case.</p>\r\n\r\n<p>The next few articles discuss how to describe the algorithm carefully, how to implement the algorithm in JavaScript, and how to analyze efficiency.</p>\r\n\r\n<h3>Describing binary search</h3>\r\n\r\n<p>When describing an algorithm to a fellow human being, an incomplete description is often good enough. Some details may be left out of a recipe for a cake; the recipe assumes that you know how to open the refrigerator to get the eggs out&nbsp;and that you know how to crack the eggs. People might intuitively know how to fill in the missing details, but computer programs do not.&nbsp;That&#39;s why we need to describe computer algorithms completely.</p>\r\n\r\n<p>In order to implement an algorithm in a programming language, you will need to understand an algorithm down to the details. What are the inputs to the problem? The outputs? What variables should be created, and what initial values should they have? What intermediate steps should be taken to compute other values and to ultimately compute the output? Do these steps repeat instructions that can be written in simplified form using a loop?</p>\r\n\r\n<p>Let&#39;s look at how to describe binary search carefully. The main idea of binary search is to keep track of the current range of reasonable guesses. Let&#39;s say that I&#39;m thinking of a number between one&nbsp;and 100, just like&nbsp;<a href=\"https://www.khanacademy.org/computing/computer-science/algorithms/intro-to-algorithms/a/a-guessing-game\">the guessing game</a>. If you&#39;ve already guessed 25 and I told you my number was higher, and you&#39;ve already guessed 81 and I told you my number was lower, then the numbers in the range from 26 to 80 are the only reasonable guesses. Here, the red section of the number line contains the reasonable guesses, and the black section shows the guesses that we&#39;ve ruled out:</p>\r\n\r\n<p><img src=\"https://ka-perseus-images.s3.amazonaws.com/91981c0666c061815dd0e9b473ad0570a1803a45.png\" /></p>\r\n\r\n<p>In each turn, you choose a guess that divides the set of reasonable guesses into two ranges of roughly the same size. If your guess is not correct, then I tell you whether it&#39;s too high or too low, and you can eliminate about half of the reasonable guesses. For example, if the current range of reasonable guesses is 26 to 80, you would guess the halfway point,&nbsp;(26 + 80) / 2(26+80)/2left parenthesis, 26, plus, 80, right parenthesis, slash, 2, or 53. If I then tell you that 53 is too high, you can eliminate all numbers from 53 to 80, leaving 26 to 52 as the new range of reasonable guesses, halving the size of the range.</p>\r\n\r\n<p><img src=\"https://ka-perseus-images.s3.amazonaws.com/a376ce2d2746fc126293571121a818f395a97354.png\" /></p>\r\n\r\n<p>For the guessing game, we can keep track of the set of reasonable guesses using a few variables. Let the variable&nbsp;minminm, i, n&nbsp;be the current minimum reasonable guess for this round, and let the variable&nbsp;maxmaxm, a, x&nbsp;be the current maximum reasonable guess. The&nbsp;<em>input</em>&nbsp;to the problem is the number&nbsp;nnn, the highest possible number that your opponent is thinking of. We assume that the lowest possible number is one, but it would be easy to modify the algorithm to take the lowest possible number as a second input.</p>\r\n\r\n<p>Here&#39;s a step-by-step description of using binary search to play the guessing game:</p>\r\n\r\n<ol>\r\n	<li>Let&nbsp;min = 1min=1m, i, n, equals, 1&nbsp;and&nbsp;max = nmax=nm, a, x, equals, n.</li>\r\n	<li>Guess the average of&nbsp;maxmaxm, a, x&nbsp;and&nbsp;minminm, i, n, rounded down&nbsp;so that it is an integer.</li>\r\n	<li>If you guessed the number, stop. You found it!</li>\r\n	<li>If the guess was too low, set&nbsp;minminm, i, n&nbsp;to be one larger than the guess.</li>\r\n	<li>If the guess was too high, set&nbsp;maxmaxm, a, x&nbsp;to be one smaller than the guess.</li>\r\n	<li>Go back to step two.</li>\r\n</ol>\r\n\r\n<p>We could make that description even more precise by clearly describing the inputs and the outputs for the algorithm&nbsp;and by clarifying what we mean by instructions like &quot;guess a number&quot; and &quot;stop.&quot; But this is enough detail for now.</p>', '2018-07-02 00:23:17', '2018-07-02 00:23:17', 'Binary Search', 'binary-search'),
(5, 2, '<p>Recall that the Greatest Common Divisor (GCD) of two integers A and B is the&nbsp;<strong>largest integer that divides both A and B</strong>.</p>\r\n\r\n<p>The&nbsp;<strong>Euclidean Algorithm</strong>&nbsp;is a technique for quickly finding the&nbsp;<strong>GCD</strong>&nbsp;of two integers.</p>\r\n\r\n<h2>The Algorithm</h2>\r\n\r\n<p>The Euclidean Algorithm for finding GCD(A,B) is as follows:</p>\r\n\r\n<ul>\r\n	<li>If A = 0 then GCD(A,B)=B, since the GCD(0,B)=B, and we can stop. &nbsp;</li>\r\n	<li>If B = 0 then GCD(A,B)=A, since the GCD(A,0)=A, and we can stop. &nbsp;</li>\r\n	<li>Write A in quotient remainder form (A = B&sdot;Q + R)</li>\r\n	<li>Find GCD(B,R) using the Euclidean Algorithm since GCD(A,B) = GCD(B,R)</li>\r\n</ul>\r\n\r\n<h2>Example:</h2>\r\n\r\n<p>Find the GCD of 270 and 192</p>\r\n\r\n<ul>\r\n	<li>A=270, B=192</li>\r\n	<li>A &ne;0</li>\r\n	<li>B &ne;0</li>\r\n	<li>Use long division to find that 270/192 = 1 with a remainder of 78. We can write this as: 270 = 192 * 1 +78</li>\r\n	<li>Find GCD(192,78), since GCD(270,192)=GCD(192,78)</li>\r\n</ul>\r\n\r\n<p>A=192, B=78</p>\r\n\r\n<ul>\r\n	<li>A &ne;0</li>\r\n	<li>B &ne;0</li>\r\n	<li>Use long division to find that 192/78 = 2 with a remainder of 36. We can write this as:</li>\r\n	<li>192 = 78 * 2 + 36</li>\r\n	<li>Find GCD(78,36), since GCD(192,78)=GCD(78,36)</li>\r\n</ul>\r\n\r\n<p>A=78, B=36</p>\r\n\r\n<ul>\r\n	<li>A &ne;0</li>\r\n	<li>B &ne;0</li>\r\n	<li>Use long division to find that 78/36 = 2 with a remainder of 6. We can write this as:</li>\r\n	<li>78 = 36 * 2 + 6</li>\r\n	<li>Find GCD(36,6), since GCD(78,36)=GCD(36,6)</li>\r\n</ul>\r\n\r\n<p>A=36, B=6</p>\r\n\r\n<ul>\r\n	<li>A &ne;0</li>\r\n	<li>B &ne;0</li>\r\n	<li>Use long division to find that 36/6 = 6 with a remainder of 0. We can write this as:</li>\r\n	<li>36 = 6 * 6 + 0</li>\r\n	<li>Find GCD(6,0), since GCD(36,6)=GCD(6,0)</li>\r\n</ul>\r\n\r\n<p>A=6, B=0</p>\r\n\r\n<ul>\r\n	<li>A &ne;0</li>\r\n	<li>B =0, GCD(6,0)=6</li>\r\n</ul>\r\n\r\n<p><strong>So we have shown:</strong></p>\r\n\r\n<p>GCD(270,192) = GCD(192,78) = GCD(78,36) = GCD(36,6) = GCD(6,0) = 6</p>\r\n\r\n<p><strong>GCD(270,192) = 6</strong></p>\r\n\r\n<h2>Understanding the Euclidean Algorithm</h2>\r\n\r\n<p>If we examine the Euclidean Algorithm we can see that it makes use of the following properties:</p>\r\n\r\n<ul>\r\n	<li>GCD(A,0) = A</li>\r\n	<li>GCD(0,B) = B</li>\r\n	<li><strong>If A = B&sdot;Q + R and B&ne;0 then GCD(A,B) = GCD(B,R)</strong>&nbsp;where Q is an integer, R is an integer between 0 and B-1</li>\r\n</ul>\r\n\r\n<p>The first two properties let us find the GCD if either number is 0. The third property lets us take a larger, more difficult to solve problem, and&nbsp;<strong>reduce it to a smaller, easier to solve problem</strong>.</p>\r\n\r\n<p>The Euclidean Algorithm makes use of these properties by rapidly reducing the problem into easier and easier problems, using the third property, &nbsp;until it is easily solved by using one of the first two properties.</p>\r\n\r\n<p>We can understand why these properties work by proving them.</p>\r\n\r\n<p>We can prove that GCD(A,0)=A is as follows:</p>\r\n\r\n<ul>\r\n	<li>The largest integer that can evenly divide A is A.</li>\r\n	<li>All integers evenly divide 0, since for any integer, C, we can write C &sdot; 0 = 0. So we can conclude that A must evenly divide 0.</li>\r\n	<li>The greatest number that divides both A and 0 is A.</li>\r\n</ul>\r\n\r\n<p>The proof for&nbsp;<strong>GCD(0,B)=B</strong>&nbsp;is similar. (Same proof, but we replace A with B).</p>\r\n\r\n<p>To prove that&nbsp;<strong>GCD(A,B)=GCD(B,R)</strong>&nbsp;we first need to show that&nbsp;<strong>GCD(A,B)=GCD(B,A-B)</strong>.</p>\r\n\r\n<p><img src=\"https://ka-perseus-images.s3.amazonaws.com/d6568dc48504e7a948ceffc61de4802868d28f76.png\" /></p>\r\n\r\n<p>Suppose we have three integers&nbsp;<strong>A,B</strong>&nbsp;and&nbsp;<strong>C</strong>&nbsp;such that&nbsp;<strong>A-B=C</strong>.</p>\r\n\r\n<p><strong>Proof that the GCD(A,B) evenly divides C</strong></p>\r\n\r\n<p>The GCD(A,B), by definition, evenly divides A. As a result, A must be some multiple of GCD(A,B). i.e. X&sdot;GCD(A,B)=A where X is some integer</p>\r\n\r\n<p>The GCD(A,B), by definition, evenly divides B. As a result, &nbsp;B must be some multiple of GCD(A,B). i.e. Y&sdot;GCD(A,B)=B where Y is some integer</p>\r\n\r\n<p>A-B=C gives us:</p>\r\n\r\n<ul>\r\n	<li>X&sdot;GCD(A,B) - Y&sdot;GCD(A,B) = C</li>\r\n	<li>(X - Y)&sdot;GCD(A,B) = C</li>\r\n</ul>\r\n\r\n<p>So we can see that GCD(A,B) evenly divides C.</p>\r\n\r\n<p>An illustration of this proof &nbsp;is shown in the left portion of the figure below:</p>\r\n\r\n<p><img src=\"https://ka-perseus-images.s3.amazonaws.com/6b6e1950ccd637d77235017c258b86378a4cba54.png\" /></p>\r\n\r\n<p><strong>Proof that the GCD(B,C) evenly divides A</strong></p>\r\n\r\n<p>The GCD(B,C), by definition, evenly divides B. As a result, B must be some multiple of GCD(B,C). i.e. M&sdot;GCD(B,C)=B where M is some integer</p>\r\n\r\n<p>The GCD(B,C), by definition, evenly divides C. As a result, &nbsp;C must be some multiple of GCD(B,C). i.e. N&sdot;GCD(B,C)=C where N is some integer</p>\r\n\r\n<p>A-B=C gives us:</p>\r\n\r\n<ul>\r\n	<li>B+C=A</li>\r\n	<li>M&sdot;GCD(B,C) + N&sdot;GCD(B,C) = A</li>\r\n	<li>(M + N)&sdot;GCD(B,C) = A</li>\r\n</ul>\r\n\r\n<p>So we can see that GCD(B,C) evenly divides A.</p>\r\n\r\n<p>An illustration of this proof &nbsp;is shown in the figure below</p>\r\n\r\n<p><img src=\"https://ka-perseus-images.s3.amazonaws.com/bdaae4e94ab086d57f14df18ee01abf5f36f49e4.png\" /></p>\r\n\r\n<p><strong>Proof that GCD(A,B)=GCD(A,A-B)</strong></p>\r\n\r\n<ul>\r\n	<li>GCD(A,B) by definition, evenly divides B.</li>\r\n	<li>We proved that GCD(A,B) evenly divides C.</li>\r\n	<li>Since the GCD(A,B) divides both B and C evenly it is a common divisor of B and C.</li>\r\n</ul>\r\n\r\n<p><strong>GCD(A,B) must be less than or equal to, GCD(B,C), because GCD(B,C) is the &ldquo;greatest&rdquo; common divisor of B and C.</strong></p>\r\n\r\n<ul>\r\n	<li>GCD(B,C) by definition, evenly divides B.</li>\r\n	<li>We proved that GCD(B,C) evenly divides A.</li>\r\n	<li>Since the GCD(B,C) divides both A and B evenly it is a common divisor of A and B.</li>\r\n</ul>\r\n\r\n<p>GCD(B,C) must be less than or equal to, GCD(A,B), because GCD(A,B) is the&nbsp;<strong>&ldquo;greatest&rdquo;</strong>&nbsp;common divisor of A and B.</p>\r\n\r\n<p>Given that GCD(A,B)&le;GCD(B,C) and GCD(B,C)&le;GCD(A,B) we can conclude that:</p>\r\n\r\n<p><strong>GCD(A,B)=GCD(B,C)</strong></p>\r\n\r\n<p>Which is equivalent to:</p>\r\n\r\n<p><strong>GCD(A,B)=GCD(B,A-B)</strong></p>\r\n\r\n<p>An illustration of this proof &nbsp;is shown in the right portion of the figure below.</p>\r\n\r\n<p><img src=\"https://ka-perseus-images.s3.amazonaws.com/d6568dc48504e7a948ceffc61de4802868d28f76.png\" /></p>\r\n\r\n<p><strong>Proof that GCD(A,B) = GCD(B,R)</strong></p>\r\n\r\n<p>We proved that GCD(A,B)=GCD(B,A-B)</p>\r\n\r\n<p>The order of the terms does not matter so we can say GCD(A,B)=GCD(A-B,B)</p>\r\n\r\n<p>We can repeatedly apply GCD(A,B)=GCD(A-B,B) to obtain:</p>\r\n\r\n<p>GCD(A,B)=GCD(A-B,B)=GCD(A-2B,B)=GCD(A-3B,B)=...=GCD(A-Q&sdot;B,B)</p>\r\n\r\n<p>But A= B&sdot;Q + R so &nbsp;A-Q&sdot;B=R</p>\r\n\r\n<p>Thus&nbsp;<strong>GCD(A,B)=GCD(R,B)</strong></p>\r\n\r\n<p>The order of terms does not matter, thus:</p>\r\n\r\n<p><strong>GCD(A,B)=GCD(B,R)</strong></p>', '2018-07-02 00:37:45', '2018-07-02 00:37:45', 'GCD Euclid', 'gcd-euclid'),
(6, 21, '<h2>Why a Balanced Binary Tree is good?</h2>\r\n\r\n<p><a href=\"https://i1.wp.com/blog.anudeep2011.com/wp-content/uploads/2014/04/CompleteBinaryTree_1000.gif\"><img alt=\"Balanced Binary Tree\" src=\"https://i1.wp.com/blog.anudeep2011.com/wp-content/uploads/2014/04/CompleteBinaryTree_1000.gif?zoom=1.25&amp;resize=412%2C249\" style=\"height:249px; width:412px\" /></a></p>\r\n\r\n<p>Balanced Binary Tree</p>\r\n\r\n<p>A balanced binary tree with&nbsp;<strong>N</strong>&nbsp;nodes has a height of&nbsp;<strong>l</strong><strong>og N</strong>. This gives us the following properties:</p>\r\n\r\n<ul>\r\n	<li>You need to visit at most&nbsp;<strong>log N</strong>&nbsp;nodes to reach&nbsp;<strong>root</strong>&nbsp;node from any other node</li>\r\n	<li>You need to visit at most&nbsp;<strong>2 * log N</strong>&nbsp;nodes to reach from any node to any other node in the tree</li>\r\n</ul>\r\n\r\n<p>The&nbsp;<strong>log&nbsp;</strong>factor is always good in the world of competitive programming 🙂</p>\r\n\r\n<p>Now, if a balanced binary tree with&nbsp;<strong>N&nbsp;</strong>nodes&nbsp;is given, then many queries can be done with&nbsp;<strong>O( log N )</strong>&nbsp;complexity. Distance of a path, Maximum/Minimum in a path, Maximum contiguous sum etc etc.</p>\r\n\r\n<h2>Why a Chain is good?</h2>\r\n\r\n<p><a href=\"https://i1.wp.com/blog.anudeep2011.com/wp-content/uploads/2014/04/flat.png\"><img alt=\"flat\" src=\"https://i1.wp.com/blog.anudeep2011.com/wp-content/uploads/2014/04/flat.png?zoom=1.25&amp;resize=555%2C59\" style=\"height:59px; width:555px\" /></a></p>\r\n\r\n<p>A chain is a set of nodes connected one after another. It can be viewed as a simple array of nodes/numbers. We can do many operations on array of elements with&nbsp;<strong>O(</strong>&nbsp;<strong>log N )&nbsp;</strong>complexity&nbsp;using&nbsp;<strong>segment tree / BIT /</strong>&nbsp;other<strong>&nbsp;</strong>data structures. You can read more about segment trees&nbsp;<a href=\"http://letuskode.blogspot.in/2013/01/segtrees.html\">here &ndash; A tutorial by Utkarsh</a>&nbsp;.</p>\r\n\r\n<p>Now, we know that Balanced Binary Trees and arrays are good for computation. We can do a lot of operations with&nbsp;<strong>O( log N )&nbsp;</strong>complexity on both the data structures.</p>\r\n\r\n<h2>Why an Unbalanced Tree is bad?</h2>\r\n\r\n<p>Height of unbalanced tree can be&nbsp;arbitrary. In the worst case, we have to visit&nbsp;<strong>O( N )</strong>&nbsp;nodes to move from one node to another node. So Unbalanced trees are not computation friendly. We shall see how we can deal with unbalanced trees.</p>\r\n\r\n<h2>Consider this example..</h2>\r\n\r\n<p><strong>Consider the following question</strong>: Given&nbsp;<strong>A&nbsp;</strong>and&nbsp;<strong>B</strong>, calculate the sum of all node values on the path from&nbsp;<strong>A&nbsp;</strong>to&nbsp;<strong>B</strong>.</p>\r\n\r\n<p><a href=\"https://i0.wp.com/blog.anudeep2011.com/wp-content/uploads/2014/04/Untitled-Diagram-1.png\"><img alt=\"Simple Tree\" src=\"https://i0.wp.com/blog.anudeep2011.com/wp-content/uploads/2014/04/Untitled-Diagram-1.png?zoom=1.25&amp;resize=573%2C519\" style=\"height:519px; width:573px\" /></a></p>\r\n\r\n<p>Here are details about the given images</p>\r\n\r\n<ol>\r\n	<li>The tree in the image has&nbsp;<strong>N&nbsp;</strong>nodes.</li>\r\n	<li>We need to visit&nbsp;<strong>N/3&nbsp;</strong>nodes to travel from&nbsp;<strong>A&nbsp;</strong>to&nbsp;<strong>D</strong>.</li>\r\n	<li>We need to visit&nbsp;<strong>&gt;N/3&nbsp;</strong>nodes to travel from&nbsp;<strong>B</strong><strong>&nbsp;</strong>to&nbsp;<strong>D</strong>.</li>\r\n	<li>We need to visit&nbsp;<strong>&gt;N/2&nbsp;</strong>nodes to travel from&nbsp;<strong>C</strong><strong>&nbsp;</strong>to&nbsp;<strong>D</strong>.</li>\r\n</ol>\r\n\r\n<p>It is clear that moving from one node to another can be up to&nbsp;<strong>O( N )</strong>&nbsp;complexity.</p>\r\n\r\n<p><strong>This is important:&nbsp;</strong>What if we broke the tree in to 3 chains as shown in image below. Then we consider each chain as an independent problem. We are dealing with chains so we can use Segment Trees/other data structures that work well on linear list of data.</p>\r\n\r\n<p><a href=\"https://i1.wp.com/blog.anudeep2011.com/wp-content/uploads/2014/04/Untitled-Diagram-1-1.png\"><img alt=\"Decomposed Tree\" src=\"https://i1.wp.com/blog.anudeep2011.com/wp-content/uploads/2014/04/Untitled-Diagram-1-1.png?zoom=1.25&amp;resize=573%2C519\" style=\"height:519px; width:573px\" /></a></p>\r\n\r\n<p>Here are the details after the trick</p>\r\n\r\n<ol>\r\n	<li>The tree still has&nbsp;<strong>N&nbsp;</strong>nodes, but it is&nbsp;<strong>DECOMPOSED&nbsp;</strong>into 3 chains each of size&nbsp;<strong>N/3</strong>. See 3 different colors, each one is a chain.</li>\r\n	<li><strong>A&nbsp;</strong>and&nbsp;<strong>D</strong><strong>&nbsp;</strong>belong to the same chain. We can get the required sum of node values of path from&nbsp;<strong>A&nbsp;</strong>to&nbsp;<strong>D&nbsp;</strong>in&nbsp;<strong>O( log N )</strong>&nbsp;time using segment tree data structure.</li>\r\n	<li><strong>B&nbsp;</strong>belongs to yellow chain, and&nbsp;<strong>D</strong><strong>&nbsp;</strong>belongs to blue chain. Path from&nbsp;<strong>B&nbsp;</strong>to&nbsp;<strong>D&nbsp;</strong>can be broken as&nbsp;<strong>B</strong><strong>&nbsp;</strong>to&nbsp;<strong>T3</strong>&nbsp;and&nbsp;<strong>T4&nbsp;</strong>to&nbsp;<strong>D</strong>. Now we are dealing with 2 cases which are similar to the above case. We can calculate required sum in&nbsp;<strong>O( log N )&nbsp;</strong>time for&nbsp;<strong>B&nbsp;</strong>to&nbsp;<strong>T3</strong>&nbsp;and&nbsp;<strong>O( log N )&nbsp;</strong>time for&nbsp;<strong>T4&nbsp;</strong>to&nbsp;<strong>D</strong>. Great, we reduced this to&nbsp;<strong>O( log N )</strong>.</li>\r\n	<li><strong>C</strong>&nbsp;belongs to red chain, and&nbsp;<strong>D&nbsp;</strong>belongs to blue chain. Path from&nbsp;<strong>C&nbsp;</strong>to&nbsp;<strong>D&nbsp;</strong>can be broken as&nbsp;<strong>C&nbsp;</strong>to&nbsp;<strong>T1</strong>,<strong>&nbsp;</strong><strong>T2&nbsp;</strong>to&nbsp;<strong>T3&nbsp;</strong>and&nbsp;<strong>T4&nbsp;</strong>to&nbsp;<strong>D</strong>. Again we are dealing with 3 cases similar to 2nd case. So we can again do it in&nbsp;<strong>O( log N )</strong>.</li>\r\n</ol>\r\n\r\n<p>Awesome!! We used concepts of&nbsp;<strong>Decomposition&nbsp;</strong>and&nbsp;<strong>Segment Tree DS</strong>, reduced the query complexity from&nbsp;<strong>O( N )</strong>&nbsp;to&nbsp;<strong>O( log N )</strong>. As I said before, competitive programmers always love the&nbsp;<strong>log&nbsp;</strong>factors 😀 😀</p>\r\n\r\n<p>But wait the tree in the example is special, only 2 nodes had degree greater than 2. We did a simple decomposition and achieved better complexity, but in a general tree we need to do some thing little more complex to get better complexity. And that little more complex decomposition is called&nbsp;<strong>Heavy Light Decomposition</strong>.</p>\r\n\r\n<h2>Basic Idea</h2>\r\n\r\n<p>We will divide the tree into&nbsp;<strong>vertex-disjoint chains</strong>&nbsp;( Meaning no two chains has a node in common ) in such a way that to move from<strong>&nbsp;any node&nbsp;</strong>in the tree to the<strong>&nbsp;root&nbsp;</strong>node, we will have to&nbsp;<strong>change at most</strong>&nbsp;<strong>log N</strong>&nbsp;chains. To put it in another words, the path from&nbsp;<strong>any node</strong>&nbsp;to&nbsp;<strong>root</strong>&nbsp;can be broken into pieces such that the each piece belongs to only one chain, then we will have no more than&nbsp;<strong>l</strong><strong>og N&nbsp;</strong>pieces.</p>\r\n\r\n<p>Let us assume that the above is done, So what?. Now the path from any node&nbsp;<strong>A</strong>&nbsp;to any node&nbsp;<strong>B&nbsp;</strong>can be &nbsp;broken into two paths:&nbsp;<strong>A&nbsp;</strong>to&nbsp;<strong>LCA( A, B )</strong>&nbsp;and&nbsp;<strong>B&nbsp;</strong>to&nbsp;<strong>LCA( A, B )</strong>. Details about LCA &ndash;&nbsp;<a href=\"http://en.wikipedia.org/wiki/Lowest_common_ancestor\">Click Here</a>&nbsp;or&nbsp;<a href=\"http://www.topcoder.com/tc?d1=tutorials&amp;d2=lowestCommonAncestor&amp;module=Static\">Here</a>. So at this point we need to only worry about paths of the following format:&nbsp;<strong>Start at some node and go up the tree&nbsp;</strong>because&nbsp;<strong>A&nbsp;</strong>to&nbsp;<strong>LCA( A, B )&nbsp;</strong>and&nbsp;<strong>B&nbsp;</strong>to&nbsp;<strong>LCA( A, B )</strong>&nbsp;are both such paths.</p>\r\n\r\n<p>What are we up to till now?</p>\r\n\r\n<ul>\r\n	<li>We assumed that we can break tree into chains such that we will have to&nbsp;<strong>change at most</strong><strong>&nbsp;log N</strong>&nbsp;chains to move from any node up the tree to any other node.</li>\r\n	<li>Any path can be broken into two paths such both paths start at some node and move up the tree</li>\r\n	<li>We already know that queries in each chain can be answered with&nbsp;<strong>O( log N )&nbsp;</strong>complexity and there are at most&nbsp;<strong>log N</strong><strong>&nbsp;</strong>chains we need to consider per path. So on the whole we have&nbsp;<strong>O( log^2 N )&nbsp;</strong>complexity solution. Great!!</li>\r\n</ul>\r\n\r\n<p>Till now I have explained how&nbsp;<strong>HLD&nbsp;</strong>can be used to reduce complexity. Now we shall see details about how&nbsp;<strong>HLD&nbsp;</strong>actually decomposes the tree.</p>\r\n\r\n<p><strong>Note : My version of HLD is little different from the standard one, but still everything said above holds.</strong></p>\r\n\r\n<h2>&nbsp;Terminology</h2>\r\n\r\n<p>Common tree related terminology can be found&nbsp;<a href=\"http://en.wikipedia.org/wiki/Tree_(data_structure)#Terminology\">here</a>.</p>\r\n\r\n<p><strong>Special Child :&nbsp;</strong>Among all child nodes of a node, the one with maximum sub-tree size is considered as&nbsp;<strong>Special child</strong>. Each non leaf node has exactly one&nbsp;<strong>Special child</strong>.</p>\r\n\r\n<p><strong>Special Edge :&nbsp;</strong>For each non-leaf node, the edge connecting the node with its&nbsp;<strong>Special&nbsp;</strong><strong>child</strong>&nbsp;is considered as&nbsp;<strong>Special Edge</strong>.</p>\r\n\r\n<p><a href=\"https://i2.wp.com/blog.anudeep2011.com/wp-content/uploads/2014/04/graph-2.png\"><img alt=\"Random Graph\" src=\"https://i2.wp.com/blog.anudeep2011.com/wp-content/uploads/2014/04/graph-2.png?zoom=1.25&amp;resize=739%2C594\" style=\"height:594px; width:739px\" /></a></p>\r\n\r\n<p><strong>Read the next 3 paras until you clearly understand every line of it, every line makes sense (Hope!). Read it 2 times 3 times 10 times 2 power 10 times .. , until you understand!!</strong></p>\r\n\r\n<p>What happens if you go to each node, find the special child and special edge and mark all special edges with green color and other edges are still black? Well, what happens is&nbsp;<strong>HLD</strong>. What would the graph look like then? Colorful yes. Not just colorful. Green edges actually forms vertex disjoint chains and black edges will be the connectors between chains. Let us explore one chain, start at root, move to the special child of root (there is only one special child, so easy pick), then to its special child and so on until you reach a leaf node, what you just traveled is a chain which starts at root node. Let us assume that root node has&nbsp;<strong>m&nbsp;</strong>child nodes. Note that all&nbsp;<strong>m-1</strong>&nbsp;normal child nodes are starting nodes of some other chains.</p>\r\n\r\n<p>What happens if you move from a node to a normal child node of it. This is the&nbsp;<strong>most important part</strong>. When you move from a node to any of its normal child, the sub-tree size is at most half the sub-tree size of current node. Consider a node&nbsp;<strong>X&nbsp;</strong>whose sub-tree size is&nbsp;<strong>s&nbsp;</strong>and has&nbsp;<strong>m</strong>&nbsp;child nodes. If&nbsp;<strong>m=1</strong>, then the only child is special child (So there is no case of moving to normal child). For&nbsp;<strong>m&gt;=2</strong>, sub-tree size of any normal child is&nbsp;<strong>&lt;=s/2</strong>. To prove that, let us talk about the sub-tree size of special child. What is the least sub-tree size possible for special child? Answer is&nbsp;<strong>ceil( s/m )</strong>&nbsp;(what is ceil?&nbsp;<a href=\"http://en.wikipedia.org/wiki/Floor_and_ceiling_functions\">click here</a>). To prove it, let us assume it is less than&nbsp;<strong>ceil( s/m )</strong>. As this child is the one with maximum sub-tree size, all other normal child nodes will be at most as large as special child,&nbsp;<strong>m&nbsp;</strong>child nodes with each less than&nbsp;<strong>ceil( s/m )</strong>&nbsp;will not sum up to&nbsp;<strong>s</strong>, so with this counter-intuition. We have the following: The mininum sub-tree size possible for special child is&nbsp;<strong>ceil( s/m )</strong>. This being said, the maximum size for normal child is&nbsp;<strong>&nbsp;s/2</strong><strong>. So when ever you move from a node to a normal child, the sub-tree size is at most&nbsp;half the sub-tree size of parent node.</strong></p>\r\n\r\n<p>We stated early that to move from&nbsp;<strong>root&nbsp;</strong>to any node (or viceversa) we need to change at most&nbsp;<strong>log N&nbsp;</strong>chains. Here is the proof; Changing a chain means we are moving for a node to a normal child, so each time we change chain we are at least halving the sub-tree size. For a tree with size&nbsp;<strong>N</strong>, we can halve it at most&nbsp;<strong>log N</strong>times (Why? Well, take a number and keep halving, let me know if it takes more than&nbsp;<strong>ceil(&nbsp;</strong><strong>log N</strong>&nbsp;) steps).</p>\r\n\r\n<p><a href=\"https://i0.wp.com/blog.anudeep2011.com/wp-content/uploads/2014/04/graph-1.png\"><img alt=\"HL Decomposed Graph\" src=\"https://i0.wp.com/blog.anudeep2011.com/wp-content/uploads/2014/04/graph-1.png?zoom=1.25&amp;resize=739%2C584\" style=\"height:583px; width:739px\" /></a></p>\r\n\r\n<p>At this point, we know what&nbsp;<strong>HLD&nbsp;</strong>is, we know why one has to use&nbsp;<strong>HLD</strong>, basic idea of&nbsp;<strong>HLD</strong>, terminology and proof. We shall now see implementation details of&nbsp;<strong>HLD&nbsp;</strong>and few related problems.</p>\r\n\r\n<h2>Implementation</h2>\r\n\r\n<p><strong>Algorithm</strong></p>\r\n\r\n<pre>\r\nHLD(curNode, Chain):\r\n    Add curNode to curChain\r\n    If curNode is LeafNode: return&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;//Nothing left to do\r\n    sc := child node with maximum sub-tree size &nbsp; &nbsp; &nbsp; //sc is the special child\r\n    HLD(sc, Chain) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;//Extend current chain to special child\r\n    for each child node cn of curNode: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;//For normal childs\r\n        if cn != sc: HLD(cn, newChain) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;//As told above, for each normal child, a new chain starts\r\n</pre>\r\n\r\n<p>Above algorithm correctly does&nbsp;<strong>HLD</strong>. But we will need bit more information when solving&nbsp;<strong>HLD&nbsp;</strong>related problems. We should be able to answer the following questions:</p>\r\n\r\n<ol>\r\n	<li>Given a node, to which chain does that node belong to.</li>\r\n	<li>Given a node, what is the position of that node in its chain.</li>\r\n	<li>Given a chain, what is the head of the chain</li>\r\n	<li>Given a chain, what is the length of the chain</li>\r\n</ol>\r\n\r\n<p>So let us see a&nbsp;<strong>C++</strong>&nbsp;implementation which covers all of the above</p>\r\n\r\n<pre>\r\n<code>int chainNo=0,chainHead[N],chainPos[N],chainInd[N],chainSize[N];\r\nvoid hld(int cur) {\r\n    if(chainHead[chainNo] == -1) chainHead[chainNo]=cur;\r\n    chainInd[cur] = chainNo;\r\n    chainPos[cur] = chainSize[chainNo];\r\n    chainSize[chainNo]++;\r\n\r\n    int ind = -1,mai = -1;\r\n    for(int i = 0; i &lt; adj[cur].sz; i++) {         if(subsize[ adj[cur][i] ] &gt; mai) {\r\n            mai = subsize[ adj[cur][i] ];\r\n            ind = i;\r\n        }\r\n    }\r\n\r\n    if(ind &gt;= 0) hld( adj[cur][ind] );\r\n\r\n    for(int i = 0; i &lt; adj[cur].sz; i++) {\r\n        if(i != ind) {\r\n            chainNo++;\r\n            hld( adj[cur][i] );\r\n        }\r\n    }\r\n}\r\n</code></pre>\r\n\r\n<p>Initially all entries of chainHead[] are set to -1. So in line 3 when ever a new chain is started, chain head is correctly assigned. As we add a new node to chain, we will note its position in the chain and increment the chain length. In the first for loop (lines 9-14) we find the child node which has maximum sub-tree size. The following if condition (line 16) is failed for leaf nodes. When the if condition passes, we expand the chain to special child. In the second for loop (lines 18-23) we recursively call the function on all normal nodes. chainNo++ ensures that we are creating a new chain for each normal child.</p>\r\n\r\n<h2>Example</h2>\r\n\r\n<p>Problem :&nbsp;<a href=\"http://www.spoj.com/problems/QTREE/\">SPOJ &ndash; QTREE</a><br />\r\nSolution : Each edge has a number associated with it. Given 2 nodes&nbsp;<strong>A&nbsp;</strong>and&nbsp;<strong>B</strong>, we need to find the edge on path from&nbsp;<strong>A&nbsp;</strong>to&nbsp;<strong>B</strong>&nbsp;with maximum value. Clearly we can break the path into&nbsp;<strong>A&nbsp;</strong>to&nbsp;<strong>LCA( A, B )&nbsp;</strong>and&nbsp;<strong>B&nbsp;</strong>to&nbsp;<strong>LCA( A, B )</strong>, calculate answer for each of them and take the maximum of both. As mentioned above as the tree need not be balanced, it may take upto&nbsp;<strong>O( N )</strong>&nbsp;to travel from&nbsp;<strong>A&nbsp;</strong>to&nbsp;<strong>LCA( A, B )</strong>&nbsp;and find the maximum. Let us use&nbsp;<strong>HLD&nbsp;</strong>as detailed above to solve the problem.</p>\r\n\r\n<p>Solution Link :&nbsp;<a href=\"https://github.com/anudeep2011/programming/blob/master/qtree.cpp\">Github &ndash; Qtree.cpp</a>&nbsp;(well commented solution)<br />\r\nI will not explain all the functions of the solution. I will explain how query works in detail</p>\r\n\r\n<p><strong>main()</strong>&nbsp;: Scans the tree, calls all required functions in order.<br />\r\n<strong>dfs()&nbsp;</strong>: Helper function. Sets up depth, subsize, parent of each node.<br />\r\n<strong>LCA()&nbsp;</strong>: Returns Lowest Common Ancestor of two node<br />\r\n<strong>make_tree()&nbsp;</strong>: Segment tree construction<br />\r\n<strong>update_tree()&nbsp;</strong>: Segment tree update. Point Update<br />\r\n<strong>query_tree()</strong>&nbsp;: Segment tree query. Range Update<br />\r\n<strong>HLD()&nbsp;</strong>: Does HL-Decomposition, similar to one explained above<br />\r\n<strong>change()&nbsp;</strong>: Performs change operation as given in problem statemenm</p>\r\n\r\n<p><strong>query()</strong>&nbsp;: We shall see in detail about the query function.</p>\r\n\r\n<pre>\r\nint query(int u, int v) {\r\n    int lca = LCA(u, v);\r\n    return max( query_up(u, lca), query_up(v, lca) );\r\n}\r\n</pre>\r\n\r\n<p>we calculate LCA(u, v). we call query_up function twice once for the path u to lca and again for the path v to lca. we take the maximum of those both as the answer.</p>\r\n\r\n<p><strong>query_up()&nbsp;</strong>: This is&nbsp;<strong>important.</strong>&nbsp;This function takes 2 nodes u, v such that v is ancestor of u. That means the path from u to v is like going up the tree. We shall see how it works.</p>\r\n\r\n<pre>\r\nint query_up(int u, int v) {\r\n    int uchain, vchain = chainInd[v], ans = -1;\r\n\r\n    while(1) {\r\n        if(uchain == vchain) {\r\n            int cur = query_tree(1, 0, ptr, posInBase[v]+1, posInBase[u]+1);\r\n            if( cur &gt; ans ) ans = cur;\r\n            break;\r\n        }\r\n        int cur = query_tree(1, 0, ptr, posInBase[chainHead[uchain]], posInBase[u]+1);\r\n        if( cur &gt; ans ) ans = cur;\r\n        u = chainHead[uchain];\r\n        u = parent(u);\r\n    }\r\n    return ans;\r\n}\r\n</pre>\r\n\r\n<p><strong>uchain&nbsp;</strong>and&nbsp;<strong>vchain</strong>&nbsp;are chain numbers in which&nbsp;<strong>u&nbsp;</strong>and&nbsp;<strong>v&nbsp;</strong>are present respectively.&nbsp;We have a while loop which goes on until we move up from&nbsp;<strong>u&nbsp;</strong>till&nbsp;<strong>v</strong>. We have 2 cases, one case is when both&nbsp;<strong>u&nbsp;</strong>and&nbsp;<strong>v&nbsp;</strong>belong to the same chain, in this case we can query for the range between&nbsp;<strong>u&nbsp;</strong>and&nbsp;<strong>v</strong>. We can stop our query at this point because we reached&nbsp;<strong>v</strong>.<br />\r\nSecond case is when&nbsp;<strong>u&nbsp;</strong>and&nbsp;<strong>v</strong>&nbsp;are in different chains. Clearly&nbsp;<strong>v&nbsp;</strong>is above in the tree than&nbsp;<strong>u</strong>. So we need to completely move up the chain of&nbsp;<strong>u</strong>&nbsp;and go to next chain above&nbsp;<strong>u</strong>. We query from<strong>&nbsp;chainHead[u]</strong>&nbsp;to&nbsp;<strong>u</strong>, update the answer. Now we need to change chain. Next node after current chain is the parent of&nbsp;<strong>chainHead[u]</strong>.</p>\r\n\r\n<p>Following image is the same tree we used above. I explained how query works on a path from&nbsp;<strong>u&nbsp;</strong>to&nbsp;<strong>v</strong>.</p>\r\n\r\n<p><a href=\"https://i2.wp.com/blog.anudeep2011.com/wp-content/uploads/2014/04/graph.png\"><img alt=\"Example Path\" src=\"https://i2.wp.com/blog.anudeep2011.com/wp-content/uploads/2014/04/graph.png?zoom=1.25&amp;resize=738%2C748\" style=\"height:747px; width:738px\" /></a></p>', '2018-07-02 00:43:57', '2018-07-02 00:46:58', 'Heavy Light Decomposition', 'heavy-light-decomposition');

-- --------------------------------------------------------

--
-- Table structure for table `material__problem__relations`
--

CREATE TABLE `material__problem__relations` (
  `material_id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material__problem__relations`
--

INSERT INTO `material__problem__relations` (`material_id`, `problem_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2018-07-02 00:18:56', '2018-07-02 00:18:56'),
(5, 10, '2018-07-02 00:39:29', '2018-07-02 00:39:29'),
(6, 12, '2018-07-02 00:47:01', '2018-07-02 00:47:01'),
(6, 13, '2018-07-02 00:47:01', '2018-07-02 00:47:01'),
(6, 14, '2018-07-02 00:47:01', '2018-07-02 00:47:01'),
(6, 15, '2018-07-02 00:47:01', '2018-07-02 00:47:01');

-- --------------------------------------------------------

--
-- Table structure for table `material__topic__relations`
--

CREATE TABLE `material__topic__relations` (
  `material_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material__topic__relations`
--

INSERT INTO `material__topic__relations` (`material_id`, `topic_id`, `created_at`, `updated_at`) VALUES
(1, 2, '2018-07-02 00:18:52', '2018-07-02 00:18:52'),
(1, 8, '2018-07-02 00:18:53', '2018-07-02 00:18:53'),
(3, 2, '2018-07-02 00:23:17', '2018-07-02 00:23:17'),
(5, 3, '2018-07-02 00:39:25', '2018-07-02 00:39:25'),
(6, 5, '2018-07-02 00:46:58', '2018-07-02 00:46:58'),
(6, 8, '2018-07-02 00:46:59', '2018-07-02 00:46:59');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_06_16_011337_create_topics_table', 1),
(4, '2018_06_16_063924_add_user_level_and_auth', 1),
(5, '2018_06_16_071731_create_materials_table', 1),
(6, '2018_06_16_080154_add_material_name', 2),
(7, '2018_06_18_020334_add_user_name', 3),
(8, '2014_10_12_000001_create_users_table', 4),
(9, '2018_06_19_142248_create_image_table', 5),
(10, '2018_06_19_145537_create_file_table', 6),
(11, '2018_06_20_051022_create_problems_table', 7),
(12, '2018_06_21_033605_add_problems_json', 8),
(25, '2018_06_26_135148_create_solutions_table', 9),
(26, '2018_06_29_105853_create_problem__topic__relations_table', 9),
(27, '2018_06_29_143759_create_material__topic__relations_table', 10),
(29, '2018_06_29_164927_create_material__problem__relations_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE `problems` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `onlinejudge` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `problemid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `difficulty` int(11) NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `problems`
--

INSERT INTO `problems` (`id`, `created_at`, `updated_at`, `onlinejudge`, `problemid`, `difficulty`, `slug`, `title`, `link`) VALUES
(1, '2018-07-02 00:11:35', '2018-07-02 00:11:35', 'SPOJ', 'METEORS', 18, 'spoj-meteors', 'Meteors', 'https://www.spoj.com/problems/METEORS/'),
(2, '2018-07-02 00:24:20', '2018-07-02 00:24:20', 'SPOJ', 'BSEARCH1', 2, 'spoj-bsearch1', 'Binary search', 'https://www.spoj.com/problems/BSEARCH1/'),
(3, '2018-07-02 00:24:45', '2018-07-02 00:24:45', 'SPOJ', 'EKO', 2, 'spoj-eko', 'Eko', 'https://www.spoj.com/problems/EKO/'),
(6, '2018-07-02 00:31:07', '2018-07-02 00:31:07', 'UVA', '10566', 3, 'uva-10566', 'Crossed Ladders', 'https://uva.onlinejudge.org/index.php?option=com_onlinejudge&Itemid=8&page=show_problem&problem=1507'),
(8, '2018-07-02 00:32:19', '2018-07-02 00:32:19', 'UVA', '11057', 2, 'uva-11057', 'Exact Sum', 'https://uva.onlinejudge.org/index.php?option=com_onlinejudge&Itemid=8&page=show_problem&problem=1998'),
(10, '2018-07-02 00:39:05', '2018-07-02 00:39:05', 'UVA', '10892', 3, 'uva-10892', 'LCM Cardinality', 'https://uva.onlinejudge.org/index.php?option=com_onlinejudge&Itemid=8&page=show_problem&problem=1833'),
(11, '2018-07-02 00:40:48', '2018-07-02 12:25:05', 'Codeforces', '379F', 21, 'codeforces-379f', 'New Year Tree', 'https://codeforces.com/problemset/problem/379/F'),
(12, '2018-07-02 00:41:52', '2018-07-02 00:41:52', 'SPOJ', 'QTREE', 21, 'spoj-qtree', 'Query on a tree', 'https://www.spoj.com/problems/QTREE/'),
(13, '2018-07-02 00:42:16', '2018-07-02 00:42:16', 'SPOJ', 'QTREE3', 22, 'spoj-qtree3', 'Query on a tree again!', 'https://www.spoj.com/problems/QTREE3/'),
(14, '2018-07-02 00:42:47', '2018-07-02 00:42:47', 'SPOJ', 'COT', 23, 'spoj-cot', 'Count on a tree', 'https://www.spoj.com/problems/COT/'),
(15, '2018-07-02 00:43:13', '2018-07-02 00:43:13', 'SPOJ', 'GOT', 23, 'spoj-got', 'Gao on a tree', 'https://www.spoj.com/problems/GOT/'),
(16, '2018-07-02 12:31:14', '2018-07-02 12:34:04', 'UVA', '1674', 23, 'uva-1674', 'Lightning Energy Report', 'https://uva.onlinejudge.org/index.php?option=com_onlinejudge&Itemid=8&page=show_problem&problem=4549');

-- --------------------------------------------------------

--
-- Table structure for table `problem__topic__relations`
--

CREATE TABLE `problem__topic__relations` (
  `problem_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `problem__topic__relations`
--

INSERT INTO `problem__topic__relations` (`problem_id`, `topic_id`, `created_at`, `updated_at`) VALUES
(1, 2, '2018-07-02 00:11:35', '2018-07-02 00:11:35'),
(1, 8, '2018-07-02 00:11:35', '2018-07-02 00:11:35'),
(2, 2, '2018-07-02 00:24:21', '2018-07-02 00:24:21'),
(3, 2, '2018-07-02 00:24:45', '2018-07-02 00:24:45'),
(3, 3, '2018-07-02 00:24:45', '2018-07-02 00:24:45'),
(6, 2, '2018-07-02 00:31:07', '2018-07-02 00:31:07'),
(6, 3, '2018-07-02 00:31:07', '2018-07-02 00:31:07'),
(8, 2, '2018-07-02 00:32:19', '2018-07-02 00:32:19'),
(10, 3, '2018-07-02 00:39:05', '2018-07-02 00:39:05'),
(11, 5, '2018-07-02 12:25:05', '2018-07-02 12:25:05'),
(11, 8, '2018-07-02 12:25:05', '2018-07-02 12:25:05'),
(12, 5, '2018-07-02 00:41:52', '2018-07-02 00:41:52'),
(12, 8, '2018-07-02 00:41:52', '2018-07-02 00:41:52'),
(13, 5, '2018-07-02 00:42:16', '2018-07-02 00:42:16'),
(13, 8, '2018-07-02 00:42:16', '2018-07-02 00:42:16'),
(14, 5, '2018-07-02 00:42:47', '2018-07-02 00:42:47'),
(14, 8, '2018-07-02 00:42:47', '2018-07-02 00:42:47'),
(15, 5, '2018-07-02 00:43:13', '2018-07-02 00:43:13'),
(15, 8, '2018-07-02 00:43:14', '2018-07-02 00:43:14'),
(16, 5, '2018-07-02 12:34:04', '2018-07-02 12:34:04'),
(16, 8, '2018-07-02 12:34:04', '2018-07-02 12:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `solutions`
--

CREATE TABLE `solutions` (
  `id` int(10) UNSIGNED NOT NULL,
  `problems_id` int(11) NOT NULL,
  `content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `solutions`
--

INSERT INTO `solutions` (`id`, `problems_id`, `content`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 15, '<p>Needed: Segment Tree, Map, Heavy Light Decomposition</p>\r\n\r\n<p>Kita bisa menggunakan struktur data Segment Tree untuk menyelesaikan soal ini.</p>\r\n\r\n<p>Untuk setiap segment, kita simpan sebuah map yang berisi element apa saja yang ada dalam segment tersebut.</p>\r\n\r\n<p>Karena ada log N tingkat, maka map kita pasti hanya berisi N log N data saja.</p>\r\n\r\n<p>Sehingga untuk query memiliki kompleksitas = O( log N (Segment Tree) * log N (Map) ) = O(log ^2 N)</p>\r\n\r\n<p>Tetapi karena soal ini berbentuk tree, maka kita harus memotong tree tersebut menggunakan Heavy Light Decomposition dimana proses searchnya akan memakan O(log N)</p>\r\n\r\n<p>Kompleksitas akhirnya adalah O(log ^ 3 N)</p>', 1, '2018-07-02 00:56:43', '2018-07-02 01:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `title`, `created_at`, `updated_at`, `slug`) VALUES
(1, 'Complete Search', '2018-07-01 23:56:48', '2018-07-01 23:56:48', 'complete-search'),
(2, 'Binary Search', '2018-07-01 23:57:12', '2018-07-01 23:57:12', 'binary-search'),
(3, 'Mathematics', '2018-07-01 23:58:55', '2018-07-01 23:58:55', 'mathematics'),
(4, 'Ad Hoc', '2018-07-01 23:59:28', '2018-07-01 23:59:28', 'ad-hoc'),
(5, 'Graph', '2018-07-01 23:59:36', '2018-07-01 23:59:36', 'graph'),
(6, 'Dynamic Programming', '2018-07-01 23:59:49', '2018-07-01 23:59:49', 'dynamic-programming'),
(7, 'Greedy', '2018-07-02 00:00:01', '2018-07-02 00:00:01', 'greedy'),
(8, 'Data Structure', '2018-07-02 00:04:08', '2018-07-02 00:04:08', 'data-structure');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `authentication` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `password`, `level`, `authentication`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'rapel', 'Rafael Herman Yosef', 'rafaelyosef@ymail.com', '$2y$10$9SCt3x/7CystYT0UJzu3mesKFdBabFbukyjt0ub0cjEEVoKhG.5RK', 26, 2, 'AgU9YXF7sF7wdWacHZqlqZZCfp8k5qxJwZHjtZLWVpujBNewEAJH8ge7WOQ8', '2018-06-17 19:59:39', '2018-06-21 11:24:41'),
(6, 'basic', 'basic', 'test@yahoo.com', '$2y$10$6PwbrF34zqhNWkThxwJz1uAo91tSNou8RxqCBSJ/GbVutG0ntfJSq', 0, 0, 'HaEgxkSusWFbmbGtgu8izpkKisWzexKRBC8jA2OIiXUmnOlhdBTxsqFCz8sR', '2018-06-29 08:22:48', '2018-06-29 08:22:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material__problem__relations`
--
ALTER TABLE `material__problem__relations`
  ADD PRIMARY KEY (`material_id`,`problem_id`);

--
-- Indexes for table `material__topic__relations`
--
ALTER TABLE `material__topic__relations`
  ADD PRIMARY KEY (`material_id`,`topic_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `problem__topic__relations`
--
ALTER TABLE `problem__topic__relations`
  ADD PRIMARY KEY (`problem_id`,`topic_id`);

--
-- Indexes for table `solutions`
--
ALTER TABLE `solutions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `solutions`
--
ALTER TABLE `solutions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
