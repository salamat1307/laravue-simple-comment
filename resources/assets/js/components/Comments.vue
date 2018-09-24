<template>
	<div>	
		<v-container grid-list-xl text-xs-center>
		  	<v-layout row wrap>
		  	  	<v-flex xs10 offset-xs1>
		  	  		<v-alert color="red"		  	  			  
					      :value="oops"
					      type="error"
					      v-html="error_text"
					    >					     
					</v-alert>
		  	  		 <v-card>				        
				        <v-card-title primary-title>				          				
				            <v-textarea
						          solo
						          name="input-7-4"
						          label="Добавить комментарий"
						          v-model="data.text"
						          @focus="startEditing"
						          @keyup.enter="trigger"	              
						    ></v-textarea>						    				
				        </v-card-title>				        				
				        <div v-show="state === 'editing'">
					        <v-card-actions>
					          <v-btn class="white--text" color="purple" @click="saveComment">Добавить</v-btn>
					          <v-btn class="white--text" color="purple" @click="stopEditing">Отменить</v-btn>				          
					        </v-card-actions>
				        </div>
				     </v-card>		  	  		
		  	  	</v-flex>
		  	</v-layout>
		  	<div>
				<comment 
					v-for="(comment, index) in comments"
					:key="comment.id"
					:comment="comment"
					:user="user"
					@comment-updated="updateComment($event)"
					@comment-deleted="deleteComment($event)"
					>					
				</comment>	
			</div>
		</v-container>				    	    
	</div>
</template>
<script>
	import comment from './CommentItem'
	export default {
		props:{
			user:{
				required: true,
				type: Object
			}
		},		

		data() {
			return {
				state: 'default',
				oops: false,
				error_text: '',
				data: {
					text:''
				},
				comments:[]
			}
		},

		components:{
			comment
		},

		created() {
			this.getComments()
		},

		methods:{
			startEditing() {
				this.state = 'editing'
				this.oops = false
			},

			stopEditing() {
				this.state = 'default'
				this.data.text = ''
			},

			getComments() {
				axios.get('/comments').then((response) => {					
					this.comments = response.data.comments
				}).catch(error => {
					console.log('error');
				})
			},

			saveComment() {
				const _ = this
				
				axios.post('/comments', _.data).then(function(response){
					if (response.data.status) {
						_.comments.unshift(response.data.comment)
						_.stopEditing()	
					} else {
						_.oops = true
						_.error_text = response.data.messages.text[0]
					}
				})					
			},

			updateComment($event) {
				const _ = this

				axios.post(`/comments/update/${$event.id}`, $event).then((response) => {
					_.comments[_.commentIndex($event.id)].text = response.data.comment.text;
				}).catch(error => {
					console.log('error');
				})						        
			},

			deleteComment($event) {
				const _ = this

				axios.post(`/comments/delete/${$event.id}`, $event).then((response) => {
					this.comments.splice(_.commentIndex($event.id), 1);
				}).catch(error => {
					console.log('error');
				})							    
			},

			commentIndex(commentId) {
				return this.comments.findIndex((element) => {
                    return element.id === commentId;
                });
			}
		}
	}
</script>