<template>
    <nav class="nav" v-show="pages">
        <ul class="pagination">
            <li @click="page > 0 ? setPage(page-1) : page"
                 v-if="pages > 1"
                 :class='"page-item" + (page == 0 ? " disabled" : "")'>
                 <span class="page-link" v-html="$options.filters.translate('pagination.previous')"></span>
            </li>

            <template v-for="i in __numbers()" v-if="pages>1">
                <li v-if="i=='ellipsis'" class="page-item disabled">...</li>
                <li v-else @click="setPage(i)" :class='"page-item"+(page == i ? " active" : "")'>
                    <span class="page-link">{{ i + 1 }}</span>
                </li>
            </template>

            <li @click="page < pages ? setPage(page+1) : page"
                 v-if="pages > 1"
                 :class='"page-item" + (page == pages-1 ? " disabled" : "")'>
                <span class="page-link" v-html="$options.filters.translate('pagination.next')"></span>
            </li>
            <li class="page-link dropdown"
                v-if="pages">
                <span data-toggle="dropdown"
                   data-container="body"
                   role="button"
                   aria-haspopup="true"
                   class="dropdown-toggle"
                   aria-expanded="false">{{ (perPage > 0 ? "default.Row count :number":"default.All") | translate({number:perPage+""}) }} </span>
                <div class="dropdown-menu">
                    <div v-for="(val, idx) in pagination"
                         :key="idx"
                         :class='"dropdown-item"+(val.value==perPage?" active":"")'
                         @click.prevent="setPerPage(val.value, true)">
                         <a>{{ val.label+"" | translate }}</a>
                    </div>
                </div>
            </li>
        </ul>
    </nav>

</template>
<script>
    /**
     * Paging widget
     *
     * @prop config Object with pagination configuration
     */
    export default {
        props : ['page', 'perPage', 'pages', 'config'],

        data()
        {
            //merge config with defaults
            return Object.assign({
                currentPage : 0,    // current page
                currentPerPage : 10,   // number of items per page
                linkedRef   : null, // link to another paging for synchronization of values. only 'perPage' so far.
                btnLength   : 8,    // number of buttons to diplay
                index_from  : 0,    // index of item from which to start the page
                index_to    : 0,    // last index to get for page

                pagination : [      // items per page button data
                    { value: 5  , label: 5 },
                    { value: 10 , label: 10 },
                    { value: 30 , label: 30 },
                    { value: 50 , label: 50 },
                    { value: 100, label: 100 },
                    { value: -1 , label: 'general.Vše' }
                ]
            }, this.config);
        },

        methods : {
            setPage(val)
            {
                if (0 <= val && val <= this.pages-1) {
                    this.currentPage = val;
                    // let others know about the change
                    this.$emit('change', this.getEventData());
                }
            },
            setPerPage(val)
            {
                this.currentPage = 0;
                this.currentPerPage = val;
                // let others know about the change
                this.$emit('change', this.getEventData());
            },

            // returns data about change event
            getEventData()
            {
                return {
                    page       : this.currentPage,
                    per_page   : this.currentPerPage
                };
            },


            // prepares page numbering
            __numbers()
            {
                var numbers = [],
                    half = Math.floor( this.btnLength / 2 );

                if (this.pages <= this.btnLength) {
                    numbers = this.__range( 0, this.pages );
                }
                else if (this.page <= half) {
                    numbers = this.__range(0, this.btnLength - 2);
                    numbers.push( 'ellipsis' );
                    numbers.push( this.pages-1 );
                }
                else if (this.page >= this.pages - 1 - half) {
                    numbers = this.__range(this.pages - (this.btnLength - 2), this.pages);
                    numbers.splice( 0, 0, 'ellipsis' );
                    numbers.splice( 0, 0, 0 );
                }
                else {
                    numbers = this.__range( this.page - half+2, this.page + half-1 );
                    numbers.push( 'ellipsis' );
                    numbers.push( this.pages-1 );
                    numbers.splice( 0, 0, 'ellipsis' );
                    numbers.splice( 0, 0, 0 );
                }
                return numbers;
            },
            // gets numbers in a range
            __range(len, start)
            {
                var out = [],
                    end;
                if (start === undefined) {
                    start = 0;
                    end = len;
                } else {
                    end = start;
                    start = len;
                }
                for (var i = start; i < end; i++) {
                    out.push(i);
                }
                return out;
            },

            updatePaging()
            {
                // let others know about the change
//                this.$emit('change', this.getEventData());
            }
        },

        mounted()
        {
//            this.updatePaging();
        },

        updated()
        {
//            this.updatePaging();
        },
    }

</script>

