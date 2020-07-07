

var name = "trent";
var expected = "TRENT";


//convert
var newName = name.toUpperCase();

console.log("origin: " + name);
//expected
console.log("expect: TRENT");
console.log("result: " + newName);

var n = name.localeCompare(newName);
console.log(n);

if (n == 0) {
    console.log("SUCCESS");
} else {
    console.log("OPPS!");
}

console.log("done");
console.log("done");
console.log("done");


