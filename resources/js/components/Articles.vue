<template>
    <div>
        <h2>Articles</h2>
        <form v-on:submit.prevent="addArticle" class="mb-4">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Title" v-model="articles.title">
           </div>
         <div class="form-group">
               <textarea class="form-control" placeholder="Body" v-model="articles.body"></textarea>
        </div>
        <button type="submit" class="btn btn-light btn-block">Save</button>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
            <li v-bind:class="[{ disabled: !pagination.prev_page_url }]" class="page-item"><a @click="fetchArticles(pagination.prev_page_url)" class="page-link" href="#">Previous</a></li>
            
            <li class="page-item disabled"><a class="page-link" href="#">{{pagination.current_page}} of {{ pagination.last_page }}</a></li>
            <li v-bind:class="[{ disabled: !pagination.next_page_url }]" class="page-item"><a @click="fetchArticles(pagination.next_page_url)" class="page-link" href="#">Next</a></li>

        </ul>
        </nav>


        <div class="card card-body mb-2" v-for="article in articles" v-bind:key="article.id">
            <h3> {{ article.title}} </h3>
            <p> {{ article.body}} </p>
            <hr>
            <button @click="deleteArticle(article_id)" class="btn btn-danger">Delete</button>
        </div>
    </div>
</template>

<script>
export default {
    data (){
        return {
            articles: [],
            articles: {
                id: '',
                title: '',
                body: ''
            },
            article_id: '',
            pagination: {},
            //because we gonna use thesame form to add and edit
            edit: false
        }
    },

    created () {
        this.fetchArticles();
    },

    methods: {
        fetchArticles (page_url) {
            let vm = this;
            page_url = page_url || 'api/articles'
            fetch(page_url)
            .then(res => res.json())
            .then(res => {this.articles = res.data;
            vm.makePagination(res.meta, res.links);
            })
            .catch(err => console.log(err));
        },
        makePagination(meta, links) {
            let pagination = {
                current_page : meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            }
            this.pagination = pagination;
        },
        deleteArticle (id) {
            if(confirm('Are you sure')) {
                fetch(`api/article/${id}`, {
                    method: 'delete'
                })
                .then(res =>res.json())
                .then(data => 
                {
                    alert('Article removed');
                    this.fetchArticles();
                })
                .catch(err => console.log(err))
            }
        },
        addArticle () {
            if(this.edit === false) {
                //add
                fetch('api/article', {
                    method: 'post',
                    body: JSON.stringify(this.articles),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.articles.title = '';
                    this.articles.body = '';
                    alert('added');
                    this.fetchArticles();
                })
                
            }else {
                //update
            }
        }
    }


}
</script>

