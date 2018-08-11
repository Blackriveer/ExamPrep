namespace CatShop.Controllers
{
    using Microsoft.AspNetCore.Mvc;
    using CatShop.Models;
    using System.Linq;

    public class CatController : Controller
    {
        private readonly CatDbContext context;

        public CatController(CatDbContext context)
        {
            this.context = context;
        }

        [HttpGet]
        [Route("")]
        public ActionResult Index()
        {
            var cats = context.Cats
                .ToList();
            return View(cats);
        }

        [HttpGet]
        [Route("create")]
        public ActionResult Create()
        {
            
            return View();
        }

        [HttpPost]
        [Route("create")]
        public ActionResult Create(Cat cat)
        {
            if (ModelState.IsValid)
            {
                context.Cats.Add(cat);
                context.SaveChanges();

                return RedirectToAction("Index");
            }
            return View(cat);
        }

        [HttpGet]
        [Route("edit/{id}")]
        public ActionResult Edit(int id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var cat = context.Cats
                .First(m => m.Id == id);

            if (cat == null)
            {
                return StatusCode(500);
            }
            return View(cat);
        }

        [HttpPost]
        [Route("edit/{id}")]
        [ValidateAntiForgeryToken]
        public ActionResult EditConfirm(int id, Cat catModel)
        {
            var cat = context.Cats
                .First(m => m.Id == id);

            if (cat == null)
            {
                return NotFound();
            }

            cat.Name = catModel.Name;
            cat.Nickname = catModel.Nickname;
            cat.Price = catModel.Price;

            context.Cats.Update(cat);
            context.SaveChanges();

            return RedirectToAction("Index");
        }

        [HttpGet]
        [Route("delete/{id}")]
        public ActionResult Delete(int id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var cat = context.Cats
                .First(m => m.Id == id);

            if (cat == null)
            {
                return StatusCode(500);
            }
            return View(cat);
        }

        [HttpPost]
        [Route("delete/{id}")]
        [ValidateAntiForgeryToken]
        public ActionResult DeleteConfirm(int id, Cat catModel)
        {
            var cat = context.Cats
                .First(m => m.Id == id);

            if (cat == null)
            {
                return NotFound();
            }

            context.Cats.Remove(cat);
            context.SaveChanges();

            return RedirectToAction("Index");
        }
    }
}
