<?php
/**
 * Quotations about life
 *
 * @package QuoteThis
 */

/**
 * A function for returning an array of quotes about life.
 * Each quote is added to an individual array with the quoted
 * text and the author of the quote.
 *
 * @since 0.1
 * @return array $quotes
 */
function quote_this_life() {

	$quotes[] = array( "I still find each day too short for all the thoughts I want to think, all the walks I want to take, all the books I want to read, and all the friends I want to see.", "John Burroughs" );
	$quotes[] = array( "And in the end, it's not the years in your life that count. It's the life in your years.", "Abraham Lincoln" );
	$quotes[] = array( "Ethics cannot be based upon our obligations toward [people], but they are complete and natural only when we feel this Reverence for Life and the desire to have compassion for and to help all creatures insofar as it is in our power. I think that this ethic will become more and more recognized because of its great naturalness and because it is the foundation of a true humanism toward which we must strive if our culture is to become truly ethical.", "Albert Schweitzer" );
	$quotes[] = array( "Deliver me from writers who say the way they live doesn't matter. I'm not sure a bad person can write a good book. If art doesn't make us better, then what on earth is it for.", "Alice Walker" );
	$quotes[] = array( "Because I have loved life, I shall have no sorrow to die.", "Amelia Burr" );
	$quotes[] = array( "Dreams pass into the reality of action. From the actions stems the dream again; and this interdependence produces the highest form of living.", "Anais Nin" );
	$quotes[] = array( "Half our life is spent trying to find something to do with the time we have rushed through life trying to save.", "Will Rogers" );
	$quotes[] = array( "There are two ways to slide easily through life: to believe everything or to doubt everything; both ways save us from thinking.", "Alfred Korzybski" );

	return $quotes;
}

?>