module.exports = function(){
  this.Given(/^I visit dsa-civilwar$/,function(){
    this.driver.get('http://localhost:9000/dsa-civilwar/')
  });

  // this.When(/^I enter \"([^\"]*)\"$/, function(value){
  //   new this.Widget({
  //     root: "#"
  //   }).sendKeys(value,'\uE007');
  // });

  // this.Then(/^I should see \"([^\"]*)\"$/, function(expected){
  //   var List = this.Widget.List.extend({
  //     root: "#todo-list",
  //     childSelector: "li"
  //   })

  //   return new List().readAt(0).should.eventually.eql(expected);
  // })
  
  // this.When(/^I click a marker$/, function() {
  //   return this.Widget.click('div[title="Battle of Lansdowne"]');
  // });

  this.Then(/^I should see a modal$/, function() {
    return this.Widget.click(".battleTest").then(function (){
      return this.Widget.isPresent('.modal-open');
    }.bind(this))
    .should.eventually.eql(true);

  });

}