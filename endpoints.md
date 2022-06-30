### Endpoints 

* POST /api/v1/products                   Добавление продукта
* PATCH /api/v1/products/{id}             Обновление продукта
* GET /api/v1/products                    Просмотр продуктов (добавить visitor with_author|with_price_range) ### filters (category_ids|sortBy|price|customerId)
* GET /api/v1/products/vip                Просмотр vip продуктов (добавить visitor with_author)
* GET /api/v1/products/recent-viewed      Недавно просмотренные продукты
* GET /api/v1/products/wish-list          Недавно просмотренные продукты
* GET /api/v1/products/my                 Недавно просмотренные продукты
* GET /api/v1/products/{id}               Просмотр продукта

* GET /api/v1/banners                     Список баннеров
* GET /api/v1/categories                  Список категорий (дерево) ### filters (parent_id|title)
* GET /api/v1/categories/{id}             Просмотр категории (parents|children)

* GET /api/v1/users/popular               Список баннеров
* GET /api/v1/users/{id}                  Список баннеров




### Schemas

Banner
* id
* title
* subtitle
* link (nullable)
* cover (image url)
* order

Category
* id
* title
* is_new (boolean)
* children
* * title
* * is_new (boolean)
* * children

Product
* id
* image (main)
* title
* price (string)
* price_with_discount (string|nullable)
* discount (integer)
* rating (integer) (range {0-5})
* ratings_count (integer)
* is_wish (boolean)
* is_top_seller (boolean)
    
ProductFull
* id
* images
* title
* description
* rating
* ratings_count
* is_wish
* price (string)
* discount_price (string|nullable)
* is_preorder (todo preorder time "За два дня")
* published_at
* owner
* * full_name
* * avatar
* * phone
* * location
* * * latitude
* * * .
