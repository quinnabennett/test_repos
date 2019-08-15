<?php

echo "\nHow it works:

This program is designed to take two inputs. First, it needs a numeric value. Second, it needs another numeric value between 1 and 62 (inclusive).
It will convert the first value from base 10 (decimal) to base (whatever the second number is). If that doesn't make any sense, try it out.

As you can imagine, it might be hard to work with values in anything higher than base 10, because we don't have numerals to represent values above 9.
To solve this, we use letters. For example, counting upwards, we would go '...6, 7, 8, 9, a, b, c...' and so on. Once we've run out of lowercase
letters, we switch to uppercase: '...w, x, y, z, A, B, C...' Lowercase 'a' represents 10, uppercase 'A' represents 36. Have fun!

P.S:
	Please note that while the program is designed to be pretty tough, it can occasionally get hurt. Try not to be too rude. :)

Let's get started!\n\n";

global $haikus;
$haikus = array(array(
"I know something cool
I bet you don't know what it is
(today is sunday)",
"today is monday
I hope you have a great week
goodbye then, human",
"tuesday is quite weird
that's because it's not green yet
I hope you're confused",
"wends-day, wed-nes-day
no matter what, it's so odd
I think I'll just leave",
"thursday might be fine
I have plans on friday night
but thursday will work",
"I'll tell you something
I was born on a friday
but that means nothing",
"what is it they say?
saturday is for the boys?
that's a bit sexist"),
"well this is awkward
I don't write poetry much
did I do it right?",
"once there was a bird
this bird was named Georgina
that's all I can say",
"kids can talk so fast
at least relative to sloths
time doesn't exist",
"can you solve problems?
I will give you a hard task
please don't screw it up:)",
"you say I am smart
I say you are very kind
but still, you are wrong",
"you used this program
very well done sir (or ma'am)
you are dismissed now",
"exhausted surfer
stop browsing the web so late
go to sleep my dude",
"silver canopies
like mystical ceiling fans
sway in a calm breeze",
"I shot a nerf gun
I didn't get in trouble
it made me quite proud",
"welcome to 'MUR-CA'
it should be 'A-MER-I-CA'
but we say it wrong");

//ask user for num
echo "enter a number\n";
enter_num:
$num = trim(fgets(fopen("php://stdin","r")));

//check for values that will result in abnormal behaivor of the program (letters, special characters, rude users, etc.) If value is acceptable, ask user for base

if ($num == 'NO') {
  goto rude_num;
}

elseif (strtolower($num) == 'please don\'t make me do this') {
  die ("\n...ok\n");
}

elseif (strtolower($num) == 'i hate you' || strtolower($num) == 'i hate u') {
  goto impressively_insulting;
}

elseif (!ctype_digit($num)) {
  echo "\nsorry! only numeric values are accepted in this field. please try again\n";
	goto enter_num;
}

else {
  goto base;
}

rude_num:
echo "\ncome on now, ask nicely\n";
goto enter_num;

//ask user for base
base:
echo "\nenter a base (62 and below please)\n";
enter_base:
$base = strval(trim(fgets(fopen("php://stdin","r"))));

//check for base values outside of range, unexpected characters, and rude or desperate users

if ($base == 'NO') {
  goto rude_base;
}

elseif (strtolower($base) == 'please don\'t make me do this') {
  die ("\n...ok\n");
}

elseif (strtolower($base) == 'i hate you' || strtolower($base) == 'i hate u') {
  goto impressively_insulting;
}

elseif (!ctype_digit($base)) {
  echo "\nsorry! only numeric values are accepted in this field. please try again\n";
	goto enter_base;
}

elseif ($base > 62) {
	echo "\nbase too large. please enter a new base:)\n";
  goto enter_base;
}

//kills program and outputs message if base is zero
elseif ($base == 0) {
	echo ("\nbase cannot be zero. please enter a new base:)\n");
  goto enter_base;
}

else {
  goto convert;
}

rude_base:
echo "\ncome on now, ask nicely\n";
goto enter_base;

impressively_insulting:
die ("\nalright, that's enough.
that was incredibly rude.
all I'm doing is trying to help you and here you are trying to break the program and insult me.
do you like poetry? here's a haiku for you:\n
      you are really rude.
      I won't help you anymore.
      closing the program...\n\n");

convert:
echo "\noriginal value: " . $num . "\n";
echo "convert to base: " . $base . "\n\n";

//make fun of user (lightly) if they're being obnoxious
if ($num == 0) {
  echo "new value: 0 \n(that was kind of pointless, don't you think?)\n";
  goto end;
}

//set variables
$decimal = 10;
$output = null;

//create arrays for use in converting to alphanumeric values (for bases above 10)
$alphanum1 = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm');
$alphanum2 = array('n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');

//set what the largest place value will be
$max_place = floor(log($num,$base));

for ($x=0; $x<=$max_place; $x++) {

	//calculate which numeral should go in each place
	$base2pwr = pow($base, $x);
	$pre_outp = floor($num / $base2pwr);
	$outp = $pre_outp % $base;

	//translate numeric values into lowercase alphanumeric values (for bases above 10 and below 24)
	if (9 < $outp && $outp < 23) {
		$alpha_outp = $outp - 10;
		$outp = $alphanum1[$alpha_outp];
	}

	//translate numeric values into lowercase alphanumeric values (for bases above 23 and below 37)
	elseif (22 < $outp && $outp < 36) {
		$alpha_outp = $outp - 23;
		$outp = $alphanum2[$alpha_outp];
	}

	//translate numeric values into uppercase alphanumeric values (for bases above 36 and below 50)
	elseif (35 < $outp && $outp < 49) {
		$alpha_outp = $outp - 36;
		$outp = strtoupper($alphanum1[$alpha_outp]);
	}

	//translate numeric values into uppercase alphanumeric values (for bases above 49 and below 63)
	elseif (48 < $outp && $outp < 63) {
		$alpha_outp = $outp - 49;
		$outp = strtoupper($alphanum2[$alpha_outp]);
	}

	//append each numeral to the final value, starting from the units and moving upwards to the highest place value
	$output .= $outp;

}

//write output value as a string, then reverse the order of the string
echo "new value: " . strrev(strval($output)) . "\n\n";

//ask user if they want decode chart, get sassy if they don't answer well
echo "if you would like a chart for decoding, type 'yes please' (the 'please' is important. I don't deal with people without manners)
If not, you can type literally anything else, e.g. 'nah bro-fam im all chillin we gucci out here no charts needed swag dope cash money $$$'
Just please don't be rude\n\n";
$chart = strtolower(trim(fgets(fopen("php://stdin","r"))));

if ($chart == 'nah bro-fam im all chillin we gucci out here no charts needed swag dope cash money $$$') {
	echo "\nreally? that's pretty unoriginal. I mean I said you could say that, but you really couldn't think of anything else?
I hope you at least used copy and paste and didn't COMPLETELY waste your time.
oh well, I can't complain too much... you made it this far so you can't have been too rude.\n\n";
	goto end;
}

elseif ($chart == 'you\'re ugly' || $chart == 'youre ugly' || $chart == 'your ugly' || $chart == 'ur ugly' || $chart == 'you\'re dumb' || $chart == 'youre dumb' || $chart == 'your dumb' || $chart == 'ur dumb' ||
$chart == 'im being rude' || $chart == 'I don\'t need your chart') {
	echo "\nok I'm pretty sure I explicitly said not to be rude. and you're being very rude. you get a little bit of credit for making it this far, but only a little bit.
I can't believe I put up with this. I wouldn't give you the chart now even if you wanted it. even if you gave me cookies.\n\n";
	goto end;
}

elseif ($chart == 'i hate you' || $chart == 'I hate you' || $chart == 'i hate u' || $chart == 'I hate u' || $chart == 'I HATE YOU' || $chart == 'I HATE U') {
  goto impressively_insulting;
}

elseif ($chart == 'no thank you, your majesty') {
	echo ("\nmy goodness! finally, somebody polite around here! my loyal subject, you are very, very welcome. would you care for a haiku?\n\n");
	$haiku = strtolower(trim(fgets(fopen("php://stdin","r"))));

	if ($haiku == 'yes' || $haiku == 'ok' || $haiku == 'if you want' || $haiku == 'if u want' || $haiku == 'yea' || $haiku == 'sure' || $haiku == 'i guess' || $haiku == 'i guess so' || $haiku == 'fine' ||
$haiku == 'mmhmm' || $haiku == 'mm-hmm' || $haiku == 'yes please' || $haiku == 'please' || $haiku == 'yes pls' || $haiku == 'yes plz' || $haiku == 'absolutely' || $haiku == 'definitely' || $haiku == 'of course' ||
$haiku == 'for sure' || $haiku == 'always' || $haiku == 'yes your majesty' || $haiku == 'yes please, your majesty' || $haiku == 'yes please your majesty' || $haiku == 'ooo yes' || $haiku == 'most certainly' || $haiku == 'certainly' ||
$haiku == 'i would' || $haiku == 'quite' || $haiku == 'ye' || $haiku == 'surely') {
		echo ("\nhere you go!\n\n");
		$rand = array_rand($haikus,1);
		if ($rand == 0) {
			echo $haikus[0][date(w)] . "\n\n";
		}
		else {
			echo $haikus[$rand] . "\n\n";
		}
	}
	else {
		goto goodbye;
	}
}

elseif ($chart == 'yes' || $chart == 'ok' || $chart == 'if you want' || $chart == 'if u want' || $chart == 'yea' || $chart == 'sure' || $chart == 'i guess' || $chart == 'i guess so' || $chart == 'fine' ||
$chart == 'mmhmm' || $chart == 'mm-hmm' || $chart == 'please' || $chart == 'yes pls' || $chart == 'yes plz' || $chart == 'absolutely' || $chart == 'definitely' || $chart == 'of course' ||
$chart == 'for sure' || $chart == 'always' || $chart == 'yes your majesty' || $chart == 'yes please, your majesty' || $chart == 'yes please your majesty' || $chart == 'ooo yes' || $chart == 'most certainly' || $chart == 'certainly' ||
$chart == 'i would' || $chart == 'quite') {
	die("\nI do believe that it was stately quite clearly above that the 'please' was IMPORTANT! no chart for you\n\n");
}

elseif ($chart == 'yes please') {
	echo "\n0=0   1=1   2=2   3=3   4=4   5=5   6=6   7=7   8=8   9=9
a=10  b=11  c=12  d=13  e=14  f=15  g=16  h=17  i=18  j=19
k=20  l=21  m=22  n=23  o=24  p=25  q=26  r=27  s=28  t=29
u=30  v=31  w=32  x=33  y=34  z=35  A=36  B=37  C=38  D=39
E=40  F=41  G=42  H=43  I=44  J=45  K=46  L=47  M=48  N=49
O=50  P=51  Q=52  R=53  S=54  T=55  U=56  V=47  W=58  X=59
Y=60  Z=61

how to use:
	1) 	start with the rightmost character of your 'new value' and use the chart to see its numeric value (only applicable to letter characters)
	2) 	each place value in the output value is your base to a power, starting from ^0 on the right and moving up to ^n as you move to the left.
		for example, in base 10, the units place is 10^0, or 1, the next place moving left is the tens, or 10^1, next is hundreds, or 10^2, etc.
		the same principle applies to whichever base you chose. for example, if you chose base 2, the rightmost place is 2^0, or 1, next is 2^1,
		or 2, next is 2^2, or 4, and so on. multiply the value of the character in the rightmost place by the place value of that place (this is
		always 1 for the rightmost place). write that number down somewhere.
	3. 	do steps 1) and 2) for each character in your 'new value'
	4. 	add together all the numbers you've written down
	5. 	check to make sure the sum is equal to the first number you entered into the program. if it's not, then one of us did this wrong\n\n";
}

else {
goodbye:
	echo "\nalright, goodbye then...\n\n";
	goto end;
}
/* or the really easy way to do it...

echo base_convert($num, $decimal, $base) . "\n";

*/
end:
?>
