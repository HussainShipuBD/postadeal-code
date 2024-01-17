const Category = require('../models/categoryModel');
const Subcategory = require('../models/subcategoryModel');
const Supercategory = require('../models/supercategoryModel');

exports.parentCategories = async function (req, res) {
    //console.log(req.query);
    if (!req.query.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {
            let allCategories = await Category.find();


            if (!allCategories)
            	return res.status(200).json({ status: "true", result: [] });
                //return res.status(200).json({ status_code: 200, category: [] });

            let categoryList = [];
            
            /*allCategories.filter(function (mainCategory) {
                categoryList.push({
                    category_id: mainCategory._id,
                    category_name: mainCategory.name,
                    category_image: process.env.BASE_URL + process.env.CATEGORY_MEDIA_URL + mainCategory.image,
                });
            });*/

            for (var i = 0; i < allCategories.length; i++) {

                let subCategoryCount = await Subcategory.countDocuments({ parentCategory: allCategories[i]._id });


                categoryList.push({
                    category_id: allCategories[i]._id,
                    category_name: allCategories[i].name,
                    category_image: process.env.BASE_URL + process.env.CATEGORY_MEDIA_URL + allCategories[i].image,
                    sub_count: subCategoryCount,              

                });


            }

            return res.status(200).json({ status: "true", result: categoryList });
            //return res.status(200).json({ status_code: 200, category: categoryList });
        }
        catch (err) {

            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};

exports.getSubcategories = async function (req, res) {
    if (!req.query.lang_code || !req.query.category_id) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            let categoryDetails = await Category.findById(req.query.category_id).exec();
            
            let allCategories = await Subcategory.find({ parentCategory: req.query.category_id });

            if (!allCategories)
                return res.status(200).json({ status: "true", result: [] });

	    let subCategory = [];
	     let categoryList = [];


  		for (var i = 0; i < allCategories.length; i++) {
           	
           		let subcategoryList = [];
           		let superCategories = await Supercategory.find({ parentCategory: req.query.category_id, subCategory: allCategories[i]._id });
           	

           		 for (var j = 0; j < superCategories.length; j++) {
           		  
				  subcategoryList.push({	
				  "id": superCategories[j]._id,
                  "name": superCategories[j].name
				  });
           			
           		}
           		
           		 categoryList.push( {
           		 "id": allCategories[i]._id,
                 "name": allCategories[i].name,
           		 "supercat": subcategoryList
           		 });
           	


           }
                
         
            return res.status(200).json({ status: "true", category_id: categoryDetails._id, category_name: categoryDetails.name, category_image: process.env.BASE_URL + process.env.CATEGORY_MEDIA_URL + categoryDetails.image, subcat: categoryList });
            
        }
        catch (err) {

            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};

exports.allServices = async function (req, res) {
    if (!req.body.user_id || !req.body.parent_category_id || !req.body.subcategory_id) {
        return res.status(200).json({ status_code: 400, message: res.__("Invalid Params") });
    }
    else {
        try {
            let allServices = await Service.find({ status: 1, mainCategory: req.body.parent_category_id, subCategory: req.body.subcategory_id });

            if (!allServices)
                return res.status(200).json({ status_code: 200, services: [] });

            let serviceList = [];
            allServices.filter(function (eachService) {
                serviceList.push({
                    service_id: eachService._id,
                    service_name: eachService.name,
                    service_image: process.env.BASE_URL + process.env.SERVICE_MEDIA_URL + eachService.image,
                    service_price: (eachService.serviceCost) ? eachService.serviceCost.toString() : "",
                    service_pricing: res.__(eachService.costType),
                });
            });
            return res.status(200).json({ status_code: 200, services: serviceList });
        }
        catch (err) {
            return res.status(200).json({ status_code: 500, message: res.__("Something went wrong") });
        }
    }
};

exports.searchCategories = async function (req, res) {
    if (!req.body.search_key || !req.body.page) {
        return res.status(200).json({ status_code: 400, message: res.__("Invalid Params") });
    }
    else {

        let keywordLength = req.body.search_key.length;

        if (keywordLength < 3) {
            return res.status(200).json({ status_code: 400, message: res.__("Invalid Params") });
        }

        let offset = 0;
        let limit = 10;
        if (req.body.page) {
            offset = parseInt((req.body.page - 1) * 10);
        }

        let searchString = {};
        searchString.status = 1;
        searchString.name = { $regex: req.body.search_key, $options: "i" };

        let searchSuggestions = [];
        let allServices = await Service.find(searchString).populate("mainCategory").populate("subCategory").limit(limit).skip(offset);

        if (allServices) {
            allServices.filter(function (eachService) {
                searchSuggestions.push({
                    parent_category_id: eachService.mainCategory._id,
                    parent_category_name: eachService.mainCategory.name,
                    parent_category_image: process.env.BASE_URL + process.env.CATEGORY_MEDIA_URL + eachService.mainCategory.image,
                    parent_category_type: eachService.mainCategory.type,
                    subcategory_id: eachService.subCategory._id,
                    subcategory_name: eachService.subCategory.name,
                    subcategory_image: process.env.BASE_URL + process.env.CATEGORY_MEDIA_URL + eachService.subCategory.image,
                    service_id: eachService._id,
                    service_name: eachService.name,
                    service_image: process.env.BASE_URL + process.env.SERVICE_MEDIA_URL + eachService.image,
                    service_pricing: eachService.costType,
                    type: "service",
                });
            });
        }

        let allSubcategories = await Subcategory.find(searchString).populate("parentCategory").limit(limit).skip(offset);

        if (allSubcategories) {
            allSubcategories.filter(function (eachSubcategory) {
                searchSuggestions.push({
                    parent_category_id: eachSubcategory.parentCategory._id,
                    parent_category_name: eachSubcategory.parentCategory.name,
                    parent_category_image: process.env.BASE_URL + process.env.CATEGORY_MEDIA_URL + eachSubcategory.parentCategory.image,
                    parent_category_type: eachSubcategory.parentCategory.type,
                    subcategory_id: eachSubcategory._id,
                    subcategory_name: eachSubcategory.name,
                    subcategory_image: process.env.BASE_URL + process.env.CATEGORY_MEDIA_URL + eachSubcategory.image,
                    type: "subcategory",
                });
            });
        }

        let allCategories = await Category.find(searchString).limit(limit).skip(offset);

        if (allCategories) {
            allCategories.filter(function (eachCategory) {
                searchSuggestions.push({
                    parent_category_id: eachCategory._id,
                    parent_category_name: eachCategory.name,
                    parent_category_type: eachCategory.type,
                    parent_category_image: process.env.BASE_URL + process.env.CATEGORY_MEDIA_URL + eachCategory.image,
                    type: "category",
                });
            });
        }

        return res.json({ status_code: 200, items: searchSuggestions });

    }
}
