import express from 'express';



const app = express();
app.use(express.json());

app.get('/',(req, res)=>{
    res.status(200).send({msd: 'ok'})
});

const PORT = 8080; 
app.listen(PORT,()=>{
    console.log('Sistema inicializado: ', `Acesso: http://localhost:${PORT}`);
})