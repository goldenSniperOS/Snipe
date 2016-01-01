<style>
    #alert {
        position: relative;
    }
    #alert:hover:after {
        background: hsla(0,0%,0%,.8);
        border-radius: 3px;
        color: #f6f6f6;
        content: 'Dar click para cerrar';
        font: bold 12px/30px sans-serif;
        height: 30px;
        left: 50%;
        margin-left: -60px;
        position: absolute;
        text-align: center;
        top: 50px;
        width: 120px;
    }
    #alert:hover:before {
        border-bottom: 10px solid hsla(0,0%,0%,.8);
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
        content: '';
        height: 0;
        left: 50%;
        margin-left: -10px;
        position: absolute;
        top: 40px;
        width: 0;
    }

    #alert:target {
        display: none;
    }
    .alert {
        animation: alert 1s ease forwards;
        background-color: #c4453c;
        background-image: linear-gradient(135deg, transparent,
            transparent 25%, hsla(0,0%,0%,.1) 25%,
            hsla(0,0%,0%,.1) 50%, transparent 50%,
            transparent 75%, hsla(0,0%,0%,.1) 75%,
            hsla(0,0%,0%,.1));
        background-size: 20px 20px;
        box-shadow: 0 5px 0 hsla(0,0%,0%,.1);
        color: #f6f6f6;
        display: block;
        font: bold 16px/40px sans-serif;
        height: 40px;
        position: absolute;
        text-align: center;
        text-decoration: none;
        top: -45px;
        width: 100%;
    }

    @keyframes alert {
        0% { opacity: 0; }
        50% { opacity: 1; }
        100% { top: 0; }
    }
</style>
<div id="alert"><a class="alert" href="#alert">No hay Conexion a la Base de Datos</a></div>