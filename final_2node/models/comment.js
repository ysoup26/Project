const mongoose=require('mongoose');
const CommentSchema=new mongoose.Schema({
    user:String,
    text:String,
    userId:String,
    postId:String
});
module.exports=mongoose.model('Comment',CommentSchema);