const Cat = require('../models').Cat;

module.exports = {
    index: (req, res) => {
         Cat.findAll().then(cats=>{
             res.render('cat/index',{cats: cats})
         });
    },

    createGet: (req, res) => {
        res.render("cat/create")
    },

    createPost: (req, res) => {
        let args = req.body.cat;

        let errorMsg = '';
        
        if (!args.name){
            errorMsg = 'Invalid name!'
        }

        else if (!args.nickname){
            errorMsg = 'Invalid nickname'
        }
        else if (!args.price){
            errorMsg = 'Invalid price'
        }

        if (errorMsg){
            res.render('cat/create', {error: errorMsg});
            return;
        }

        Cat.create(args).then(()=>{
            res.redirect('/');
        })

    },

    editGet: (req, res) => {
        Cat.findById(req.params.id).then(cat=>{
            res.render("cat/edit",{cat: cat})
        })
    },

    editPost: (req, res) => {
        let args = req.body.cat;

        let errorMsg = '';

        if (!args.name){
            errorMsg = 'Invalid name!'
        }

        else if (!args.nickname){
            errorMsg = 'Invalid nickname'
        }
        else if (!args.price){
            errorMsg = 'Invalid price'
        }

        if (errorMsg){
            res.render('cat/edit', {error: errorMsg});
            return;
        }

        Cat.update({name: args.name, nickname: args.nickname, price: args.price},
            {where:{id:req.params.id}}
        ).then(()=>{
            res.redirect('/');
        })
    },

    deleteGet: (req, res) => {
        Cat.findById(req.params.id).then(cat=>{
            res.render("cat/delete",{cat: cat})
        })
    },

    deletePost: (req, res) => {
        Cat.destroy({
            where:{id:req.params.id}

        }).then(()=>{
            res.redirect('/');
        })
    }
};
