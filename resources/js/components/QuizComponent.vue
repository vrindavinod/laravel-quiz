<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Online Examination
                        <span class="float-right">
                            {{questionIndex+1}}/{{questions.length}}
                        </span>
                    </div>

                    <div class="card-body">
                        <span class="float-right" style="color:red;">{{time}}</span>
                        <div v-for="(question,index) in questions">

                            <div v-show="index===questionIndex">
                            {{question.question}}
                            <ol>
                                <li v-for="choice in question.answers">
                                    <label>
                                        <input type="radio"
                                        :value="choice.is_correct==true?true:choice.answer"
                                        :name="index"
                                        v-model="userResponse[index]"
                                        @click = "choices(question.id,choice.id)">
                                        {{choice.answer}}
                                    </label>
                                </li>
                            </ol>
                            </div>
                        </div>
                        <div v-show="questionIndex!=questions.length">
                            <button class="btn btn-success float-right" @click="next();postuserChoice()">Next</button>
                            <button class="btn btn-success " @click="prev()">Prev</button>
                        </div>
                        <div v-show="questionIndex===questions.length">
                            <p>
                                <center>
                                    You got: {{score()}}/{{questions.length}}
                                </center>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
var moment = require('moment');
    export default {
        
        props:['quizid','quizQuestions','hasQuizPlayed','times'],
        data(){
            return{
                questions:this.quizQuestions,
                questionIndex:0,
                userResponse:Array(this.quizQuestions.length).fill(false),
                currentQuestion:0,
                currentAnswer:0,
                clock:moment(this.times,'mm:ss')
                }
        },
        computed:{
            time:function(){
                var minsec = this.clock.format('mm:ss');
                if(minsec =='00:00'){
                    alert('Timeout!');
                    window.location.reload();
                }
                return minsec
            }
        },
        mounted() {
            setInterval(()=>{
                this.clock = moment(this.clock.subtract(1,'seconds'))
            },1000);
        },
        
        methods:{
            next(){
                console.log(this.times);
                this.questionIndex++
            },
            prev(){
                this.questionIndex--
            },
            choices(question,answer){
                this.currentAnswer = answer,
                this.currentQuestion = question
            },
            score(){
                return this.userResponse.filter((val)=>{
                    return val===true;
                }).length
            },
            postuserChoice(){
                axios.post('create',{
                    answerId:this.currentAnswer,
                    questionId:this.currentQuestion,
                    quizId:this.quizid
                }).then((response)=>{
                    console.log(response);
                }).catch((error)=>{
                    alert("Error!");
                });
            }
        }
    }
</script>
