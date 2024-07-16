<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'The Joy of PHP',
            'edition' => 1,
            'isbn' => '9781522792147',
            'publisher' => 'CreateSpace Independent Publishing Platform',
            'publication_date' => '2012-12-13',
            'image' => 'files/images/books/BOOK1/The+Joy+of+PHP.png',
            'description' => 'Have you ever wanted to design your own website or browser application but thought it would be too difficult or maybe you didn\'t know where to start? Have you found the amount of information on the Internet either too overwhelming or not geared for your skill set or worse, just plain boring? Are you interested in learning to program PHP and have some fun along the way? If so, then The Joy of PHP by Alan Forbes is the book for you!',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'Models: Attract Women Through Honesty',
            'edition' => 3,
            'isbn' => '9781463750350',
            'publisher' => 'CreateSpace Independent Publishing Platform',
            'publication_date' => '2012-12-30',
            'image' => 'files/images/books/BOOK2/Models+Attract+Women+Through+Honesty.png',
            'description' =>
            'Models is the first book ever written on seduction as an emotional process rather than a logical one, a process of connecting with women rather than impressing them. It\'s the most mature and honest guide on how a man can attract women without faking behavior, without lying and without emulating others. A game-changer.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'Lord of Goblins, Vol. 1 Definitive Edition (Lord of Goblins)',
            'edition' => 1,
            'isbn' => '9798889930075',
            'publisher' => 'CreateSpace Independent Publishing Platform',
            'publication_date' => '2023-06-08',
            'image' => 'files/images/books/BOOK3/Lord+of+Goblins%2C+Vol.+1+Definitive+Edition+(Lord+of+Goblins).png',
            'description' =>
            'Corruption. Greed. War. Lev is no stranger to the evils of the world, having spent a lifetime fighting the predatory system that ensnared the world\'s population and turned them into puppets for the leaders of humanity.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'The Hitchhiker\'s Guide to the Galaxy',
            'edition' => 50,
            'isbn' => '9780575096925',
            'publisher' => 'Pan Macmillan',
            'publication_date' => '1979-10-12',
            'image' => "files/images/books/BOOK4/The+Hitchhiker's+Guide+to+the+Galaxy.png",
            'description' =>
            'Seconds before the Earth is demolished to make way for a galactic freeway, Arthur Dent is plucked off the planet by his friend Ford Prefect, a researcher for the revised edition of The Hitchhiker\'s Guide to the Galaxy who, for the last 15 years, has been posing as an out-of-work actor.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'The Time Machine',
            'edition' => 1,
            'isbn' => '9780141975863',
            'publisher' => 'Penguin Classics',
            'publication_date' => '1895-01-01',
            'image' => 'files/images/books/BOOK5/The+Time+Machine.png',
            'description' =>
            'When a Victorian scientist propels himself into the year 802,701 AD, he is initially delighted to find that suffering has been replaced by beauty, contentment and peace. Entranced at first by the Eloi, an elfin species descended from man, he soon realises that this beautiful people are simply remnants of a once-great culture - now weak and childishly afraid of the dark. But they have every reason to be afraid: in deep tunnels beneath their paradise lurks another race descended from humanity - the sinister Morlocks. And when the scientist\'s time machine vanishes, it becomes clear he must search these tunnels, if he is ever to return to his own era.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'Pride and Prejudice',
            'edition' => 3,
            'isbn' => '9780143424680',
            'publisher' => 'Penguin Classics',
            'publication_date' => '1813-01-01',
            'image' => 'files/images/books/BOOK6/Pride+and+Prejudice.png',
            'description' =>
            'One of Jane Austen\'s most beloved works, Pride and Prejudice, is vividly brought to life by Academy Award nominee Rosamund Pike (Gone Girl). In her bright and energetic performance of this British classic, she expertly captures Austen\'s signature wit and tone. Her attention to detail, her literary background, and her performance in the 2005 feature film version of the novel provide the perfect foundation from which to convey the story of Elizabeth Bennet, her four sisters, and the inimitable Mr. Darcy.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'To Kill a Mockingbird',
            'edition' => 50,
            'isbn' => '9780143284923',
            'publisher' => 'HarperCollins',
            'publication_date' => '1960-07-01',
            'image' => 'files/images/books/BOOK7/To+Kill+a+Mockingbird.png',
            'description' => 'One of the best-loved stories of all time, To Kill a Mockingbird has been translated into more than 40 languages, sold more than 30 million copies worldwide, served as the basis for an enormously popular motion picture, and was voted one of the best novels of the 20th century by librarians across the country. A gripping, heart-wrenching, and wholly remarkable tale of coming-of-age in a South poisoned by virulent prejudice, it views a world of great beauty and savage inequities through the eyes of a young girl, as her father - a crusading local lawyer - risks everything to defend a black man unjustly accused of a terrible crime.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'The Alchemist',
            'edition' => 11,
            'isbn' => '9780671035193',
            'publisher' => 'HarperCollins',
            'publication_date' => '1988-08-01',
            'image' => 'files/images/books/BOOK8/The+Alchemist.png',
            'description' => 'Paulo Coelho\'s enchanting novel has inspired a devoted following around the world. This story, dazzling in its simplicity and wisdom, is about an Andalusian shepherd boy named Santiago who travels from his homeland in Spain to the Egyptian desert in search of treasure buried in the Pyramids. Along the way he meets a Gypsy woman, a man who calls himself king, and an Alchemist, all of whom point Santiago in the direction of his quest. No one knows what the treasure is, or if Santiago will be able to surmount the obstacles along the way But what starts out as a journey to find worldly goods turns into a meditation on the treasures found within. Lush, evocative, and deeply humane, the story of Santiago is art eternal testament to the transforming power of our dreams and the importance of listening to our hearts.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'The Handmaid\'s Tale',
            'edition' => 40,
            'isbn' => '9780312455030',
            'publisher' => 'Penguin Random House',
            'publication_date' => '1985-07-01',
            'image' => "files/images/books/BOOK9/The+Handmaid's+Tale.png",
            'description' => 'Margaret Atwood\'s popular dystopian novel The Handmaid\'s Tale explores a broad range of issues relating to power, gender, and religious politics. Multiple Golden Globe award-winner Claire Danes (Romeo and Juliet, The Hours) gives a stirring performance of this classic in speculative fiction, one of the most powerful and widely read novels of our time.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'Sapiens: A Brief History of Humankind',
            'edition' => 2,
            'isbn' => '9780316247110',
            'publisher' => 'Penguin Random House',
            'publication_date' => '2014-02-01',
            'image' => 'files/images/books/BOOK10/Sapiens+A+Brief+History+of+Humankind.png',
            'description' => 'From a renowned historian comes a groundbreaking narrative of humanity\'s creation and evolution - a #1 international bestseller - that explores the ways in which biology and history have defined us and enhanced our understanding of what it means to be "human".',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'Dracula',
            'edition' => 2,
            'isbn' => '9780062862684',
            'publisher' => 'Penguin Classics',
            'publication_date' => '1897-05-01',
            'image' => 'files/images/books/BOOK11/Dracula.png',
            'description' => 'Dracula is an 1897 Gothic horror novel by Irish author Bram Stoker.Famous for introducing the character of the vampire Count Dracula, the novel tells the story of Dracula\'s attempt to move from Transylvania to England so he may find new blood and spread undead curse, and the battle between Dracula and a small group of men and women led by Professor Abraham Van Helsing.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'One Hundred Years of Solitude',
            'edition' => 50,
            'isbn' => '9780385082786',
            'publisher' => 'Vintage Books',
            'publication_date' => '1967-05-01',
            'image' => 'files/images/books/BOOK12/One+Hundred+Years+of+Solitude.png',
            'description' => 'The novel tells the story of the rise and fall of the mythical town of Macondo through the history of the Buendia family. Rich and brilliant, it is a chronicle of life, death, and the tragicomedy of humankind. In the beautiful, ridiculous, and tawdry story of the Buendia family, one sees all of humanity, just as in the history, myths, growth, and decay of Macondo, one sees all of Latin America.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'The Martian',
            'edition' => 3,
            'isbn' => '9780552165605',
            'publisher' => 'Crown Books',
            'publication_date' => '2011-09-01',
            'image' => 'files/images/books/BOOK13/The+Martian.png',
            'description' => 'Wil Wheaton, who has lent his voice to sci-fi blockbusters like Ready Player One and Redshirts, breathes new life (and plenty of sarcasm) into the iconic character of Mark Watney, making this edition a must-listen for both longtime fans of The Martian and new listeners alike.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'The Fault in Our Stars',
            'edition' => 4,
            'isbn' => '9780312360557',
            'publisher' => 'Penguin Books',
            'publication_date' => '2012-01-01',
            'image' => 'files/images/books/BOOK14/The+Fault+in+Our+Stars.png',
            'description' => 'Despite the tumor-shrinking medical miracle that has bought her a few years, Hazel has never been anything but terminal, her final chapter inscribed upon diagnosis. But when a gorgeous plot twist named Augustus Waters suddenly appears at Cancer Kid Support Group, Hazel\'s story is about to be completely rewritten.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'Things Fall Apart',
            'edition' => 3,
            'isbn' => '9780385470940',
            'publisher' => 'Anchor Books',
            'publication_date' => '1958-08-01',
            'image' => 'files/images/books/BOOK15/Things+Fall+Apart.png',
            'description' => 'How can we live our lives when everything seems to fall apart-when we are continually overcome by fear, anxiety, and pain? The answer, Pema Chodron suggests, might be just the opposite of what you expect. Here, in her most beloved and acclaimed work, Pema shows that moving toward painful situations and becoming intimate with them can open up our hearts in ways we never before imagined. Drawing from traditional Buddhist wisdom, she offers life-changing tools for transforming suffering and negative patterns into habitual ease and boundless joy.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'Murder on the Orient Express',
            'edition' => 5,
            'isbn' => '9780062862700',
            'publisher' => 'HarperCollins',
            'publication_date' => '1934-01-01',
            'image' => 'files/images/books/BOOK16/Murder+on+the+Orient+Express.png',
            'description' => 'Just after midnight, the famous Orient Express is stopped in its tracks by a snowdrift. By morning, the millionaire Samuel Edward Ratchett lies dead in his compartment, stabbed a dozen times, his door locked from the inside. One of his fellow passengers must be the murderer.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'Dune',
            'edition' => 3,
            'isbn' => '9781631170673',
            'publisher' => 'BOOM! Studios',
            'publication_date' => '2020-01-01',
            'image' => 'files/images/books/BOOK17/Dune.png',
            'description' => 'Set on the desert planet Arrakis, Dune is the story of the boy Paul Atreides, who would become the mysterious man known as Maud\'dib. He would avenge the traitorous plot against his noble family - and would bring to fruition humankind\'s most ancient and unattainable dream.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'The Lord of the Rings',
            'edition' => 7,
            'isbn' => '9780395074673',
            'publisher' => 'Houghton Mifflin Harcourt',
            'publication_date' => '1954-09-02',
            'image' => 'files/images/books/BOOK18/The+Lord+of+the+Rings.png',
            'description' => 'In a sleepy village in the Shire, a young hobbit is entrusted with an immense task. He must make a perilous journey across Middle-earth to the Cracks of Doom, there to destroy the Ruling Ring of Power - the only thing that prevents the Dark Lord Sauron\'s evil dominion.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'The Handmaid\'s Tale',
            'edition' => 5,
            'isbn' => '9781524795031',
            'publisher' => 'Tundra Books',
            'publication_date' => '2019-09-01',
            'image' => "files/images/books/BOOK19/The+Handmaid's+Tale.png",
            'description' => 'Margaret Atwood\'s popular dystopian novel The Handmaid\'s Tale explores a broad range of issues relating to power, gender, and religious politics. Multiple Golden Globe award-winner Claire Danes (Romeo and Juliet, The Hours) gives a stirring performance of this classic in speculative fiction, one of the most powerful and widely read novels of our time.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'Sapiens: A Brief History of Humankind',
            'edition' => 7,
            'isbn' => '9780525522176',
            'publisher' => 'Zest Books',
            'publication_date' => '2020-10-01',
            'image' => 'files/images/books/BOOK20/Sapiens+A+Brief+History+of+Humankind.png',
            'description' => 'From a renowned historian comes a groundbreaking narrative of humanity\'s creation and evolution - a #1 international bestseller - that explores the ways in which biology and history have defined us and enhanced our understanding of what it means to be "human".',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'The Count of Monte Cristo',
            'edition' => 5,
            'isbn' => '9780140435567',
            'publisher' => 'Penguin Classics',
            'publication_date' => '1844-08-01',
            'image' => 'files/images/books/BOOK21/The+Count+of+Monte+Cristo.png',
            'description' => 'On the eve of his marriage to the beautiful Mercedes, having that very day been made captain of his ship, the young sailor Edmond Dantes is arrested on a charge of treason, trumped up by jealous rivals. Incarcerated for many lonely years in the isolated and terrifying Chateau d\'If near Marseille, he meticulously plans his brilliant escape and extraordinary revenge.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'Frankenstein',
            'edition' => 14,
            'isbn' => '9780143538887',
            'publisher' => 'SparkNotes',
            'publication_date' => '1818-01-01',
            'image' => 'files/images/books/BOOK22/Frankenstein.png',
            'description' => 'Narrator Dan Stevens (Downton Abbey) presents an uncanny performance of Mary Shelley\'s timeless gothic novel, an epic battle between man and monster at its greatest literary pitch. In trying to create life, the young student Victor Frankenstein unleashes forces beyond his control, setting into motion a long and tragic chain of events that brings Victor to the very brink of madness. How he tries to destroy his creation, as it destroys everything Victor loves, is a powerful story of love, friendship, scientific hubris, and horror.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'The Hitchhiker\'s Guide to the Galaxy',
            'edition' => 7,
            'isbn' => '9781623095605',
            'publisher' => 'Titan Comics',
            'publication_date' => '2019-08-01',
            'image' => "files/images/books/BOOK23/The+Hitchhiker's+Guide+to+the+Galaxy.png",
            'description' => 'Seconds before the Earth is demolished to make way for a galactic freeway, Arthur Dent is plucked off the planet by his friend Ford Prefect, a researcher for the revised edition of The Hitchhiker\'s Guide to the Galaxy who, for the last 15 years, has been posing as an out-of-work actor.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => '1984',
            'edition' => 8,
            'isbn' => '9780743274920',
            'publisher' => 'Penguin Classics',
            'publication_date' => '1949-06-08',
            'image' => 'files/images/books/BOOK24/1984.png',
            'description' => 'George Orwell\'s nineteen Eighty-Four is one of the most definitive texts of modern literature. Set in Oceania, one of the three inter-continental superstate that divided the world among themselves after a global war, Orwell\'s masterful critique of the political structures of the time, works itself out through the story of Winston Smith, a man caught in the webs of a dystopian future, and his clandestine love affair with Julia, a young woman he meets during the course of his work for the government. As much as it is an entertaining read, nineteen Eighty-Four is also a brilliant, and more importantly, a timeless satirical attack on the social and political structures of the world.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'The God of Small Things',
            'edition' => 6,
            'isbn' => '9780312642677',
            'publisher' => 'Vintage Books',
            'publication_date' => '1997-08-01',
            'image' => 'files/images/books/BOOK25/The+God+of+Small+Things.png',
            'description' => 'Set against a background of political turbulence in Kerala, Southern India, The God of Small Things tells the story of twins Esthappen and Rahel. Amongst the vats of banana jam and heaps of peppercorns in their grandmother\'s factory, they try to craft a childhood for themselves amidst what constitutes their family - their lonely, lovely mother; their beloved uncle Chacko (pickle baron, radical Marxist and bottom pincher); and their avowed enemy, Baby Kochamma (ex-nun and incumbent grand-aunt).',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'Echoes of Asgard',
            'edition' => 3,
            'isbn' => '9781524598230',
            'publisher' => 'Candlewick Press',
            'publication_date' => '2008-10-01',
            'image' => 'files/images/books/BOOK26/Echoes+of+Asgard.png',
            'description' => 'It is a dark time for Asgard. The All-Father is trapped in a bewitched Odinsleep, inspiring an all-out assault from the Frost Giants. They evade the gods\' defenses with uncommon ease, as if guided by augury. Heimdall, a quick-witted young warrior still finding his place amongst Asgard\'s defenders, believes it no coincidence that Odin lies enchanted and that the Giants are so well-informed. Sneaking into Odin\'s inner chambers, he discovers that the severed head of Mimir, a great source of wisdom, is missing. Accompanied by his sister, Lady Sif, Heimdall must quest across the Nine Realms to retrieve it, lest mighty Asgard fall.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'Money Magic',
            'edition' => 4,
            'isbn' => '9780312357891',
            'publisher' => 'Little, Brown and Company',
            'publication_date' => '2007-03-01',
            'image' => 'files/images/books/BOOK27/Money+Magic.png',
            'description' => 'Laurence Kotlikoff, one of our nation\'s premier personal finance experts and coauthor of the New York Times bestseller Get What\'s Yours: The Secrets to Maxing Out Your Social Security, harnesses the power of economics and advanced computation to deliver a host of spellbinding but simple money magic tricks that will transform your financial future.Each trick shares a basic ingredient for financial savvy based on economic common sense, not Wall Street snake oil. Money Magic offers a clear path to a richer, happier, and safer financial life. Whether you\'re making education, career, marriage, lifestyle, housing, investment, retirement, or Social Security decisions, Kotlikoff provides a clear framework for readers of all ages and income levels to learn tricks.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'Code Red',
            'edition' => 1,
            'isbn' => '9781416590217',
            'publisher' => 'HarperCollins Publishers',
            'publication_date' => '2009-07-01',
            'image' => 'files/images/books/BOOK28/Code+Red.png',
            'description' => 'Mitch Rapp owes powerful criminal Damian Losa a favour, and it\'s being called in. With no choice other than to honour his agreement, Rapp heads to Syria to stop a new designer drug spreading into Losa\'s territory. When he discovers the true culprit - someone with far bigger goals than just Syria - the scale of his mission grows.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'Whisper in the Wilds',
            'edition' => 3,
            'isbn' => '9780765384107',
            'publisher' => 'Macmillan Children\'s Publishing Group',
            'publication_date' => '2004-05-01',
            'image' => 'files/images/books/BOOK29/Whisper+in+the+Wilds.png',
            'description' => 'A preeminent figure in faith-based fiction, Lauraine Snelling has over two million copies of her works in print. In Whispers in the Wind, the second installment of Snelling\'s Wild West Wind series, Cassie Lockwood is dismayed to discover her father\'s South Dakota valley land is already occupied. Meanwhile, Cassie\'s arrival spurs the revelation of long-hidden secrets among the locals and leaves her questioning whether or not she will ever find a place to call home.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'The Girl with the Timekeeper\'s Heart',
            'edition' => 4,
            'isbn' => '9781442347092',
            'publisher' => 'Simon & Schuster',
            'publication_date' => '2006-11-01',
            'image' => "files/images/books/BOOK30/The+Girl+with+the+Timekeeper's+Heart.png",
            'description' => 'Already optioned for film, The Girl with a Clock for a Heart is Peter Swanson\'s electrifying tale of romantic noir, with shades of Hitchcock and reminiscent of the classic movie Body Heat. It is the story of a man swept into a vortex of irresistible passion and murder when an old love mysteriously reappears.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('books')->insert([
            'id' => IdGenerator::generate(['table' => 'books', 'length' => 20, 'prefix' => 'B-']),
            'name' => 'Lord of Goblins, Vol. 2',
            'edition' => 3,
            'isbn' => '9780765384297',
            'publisher' => 'MoonQuill',
            'publication_date' => '2023-04-30',
            'image' => 'files/images/books/BOOK31/Lord+of+Goblins%2C+Vol.+2.png',
            'description' => 'It should have been a simple expedition. Gather haze crystals, kill hivelings, and return to the caverns. That\'s what it should have been, but rarely are things so simple. After falling into the depths of the lower floors, Lev and the remains of the vanguard must survive in uncharted terrain and find their way back to civilization. Along the way, an ancient being drags Lev deeper into the abyss. With promises of forgotten power, it sends Lev and his party even further into the annals of this world\'s history.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
