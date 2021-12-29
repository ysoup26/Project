const mongoose=require('mongoose');
const BookSchema=new mongoose.Schema({
    title:String,
    author:String,
    category:String,
    No_of_page:String,
    description:String
});
module.exports=mongoose.model('Book',BookSchema);