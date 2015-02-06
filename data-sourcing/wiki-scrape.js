var fs      = require('fs');
var request = require('request');
var cheerio = require('cheerio');

// Battles to scrape
var battles = [ 
  "Battle_of_Edgehill", 
  "Battle_of_Marston_Moor",
  "Battle_of_Naseby",
  "Battle_of_Adwalton_Moor",
  "Battle_of_Lansdowne",
  "Battle_of_Langport",
  "Second_Battle_of_Newbury",
  "Battle_of_Hopton_Heath",
  "Battle_of_Torrington",
  "Battle_of_Turnham_Green"
];

var peopleData = [];
var battlesData = [];

for(var i = 0; i < battles.length; i++) {
  request({
    uri: "http://en.wikipedia.org/wiki/" + battles[i]
  }, function (err, response, body) {
    // Initialize cheerio
    var $ = cheerio.load(body);

    // Select geo location a each page + get the nodes text content
    var geolocation = $("span.geo-dec");
    var geoString = geolocation.html();

    // Split the latitude and longditude values into an array
    latLng = geoString.split(' ');

    // Remove unwanted text from strings
    var lat = parseFloat(latLng[0]);
    // Values on the wikipedia pages are incorrect as the longditudes should be negative values
    var lng = parseFloat('-' + latLng[1]);

    // Assign the page elements to a variables
    var name = $("#firstHeading span").html();
    var location = $(".location a").html();
    var date = $("th[style] + td").html();

    // Battle data
    var outcome = $("tr:last-child th[style] + td").html();
    var sideOne = $(".infobox tr:nth-child(6) td:first-child a:nth-child(1)").html();
    var sideTwo = $(".infobox tr:nth-child(6) td:last-child a:nth-child(1)").html();
    var leaderOne = $(".infobox tr:nth-child(8) td:first-child a").html();
    var leaderTwo = $(".infobox tr:nth-child(8) td:first-child a:last-child").html();
    var leaderThree = $(".infobox tr:nth-child(8) td:last-child a").html();
    var leaderFour = $(".infobox tr:nth-child(8) td:last-child a:last-child").html();

    // For pages with varying layouts
    if(sideOne === null) {
      sideOne = $(".infobox tr:nth-child(5) td:first-child a").html();
    }
    if(sideTwo === null) {
      sideTwo = $(".infobox tr:nth-child(5) td:last-child a").html();
    }
    if(leaderOne === null) {
      leaderOne = $(".infobox tr:nth-child(7) td:first-child a").html();
    }
    if(leaderTwo === null) {
      leaderTwo = $(".infobox tr:nth-child(7) td:last-child a").html();
    }
    if(sideOne.indexOf("img") > 0) {
      console.log('running');
      var sideOne = $(".infobox tr:nth-child(6) td:nth-child(2) a").html();
    }
    if(leaderOne === leaderTwo || leaderTwo === null || leaderTwo.indexOf("img") > 0 || leaderTwo.indexOf("span") > 0) {
      sideOneData = {
        battleName: name,
        belligerent: sideOne,
        leader: leaderOne
      };
    }
    else {
      sideOneData = {
        battleName: name,
        belligerent: sideOne,
        leader: leaderOne,
        secondLeader: leaderTwo
      };
    }

    if(leaderThree === leaderFour) {
      sideTwoData = {
        battleName: name,
        belligerent: sideTwo,
        leader: leaderThree
      };
    }
    else {
      sideTwoData = {
        battleName: name,
        belligerent: sideTwo,
        leader: leaderThree,
        secondLeader: leaderFour
      }
    }

    // Assign values to an object
    var battleData = {
      name: name,
      lat: lat,
      lng: lng,
      date: date,
      location: location,
      outcome: outcome
    };

    // pushes the objects into two arrays
    peopleData.push(sideOneData);
    peopleData.push(sideTwoData);
    battlesData.push(battleData);

    // Saves data as a json file when all battles are scraped
    if(battlesData.length === battles.length) {
      saveFile(battlesData, "civil-war-battles-data");
    }
    if(peopleData.length === (battles.length * 2)) {
      saveFile(peopleData, "civil-war-people-data");
    }
  });
}

// Saves file in JSON format
function saveFile(data, fileName) {
  outputRoute = __dirname + "/" + fileName + ".json";

  fs.writeFile(outputRoute, JSON.stringify(data, null, 4), function (err) {
      if(err) {
          console.log(err);
      } else {
          console.log("The file was saved!");
      }
  }); 
}