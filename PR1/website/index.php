<HTML>
<title>Фигуры</title>
<body>

<?php
abstract class Figure //нет никакого смысла их наследовать от единого базового класса, так как мы и так имеем прямой доступ к конкретному объекту.
// а вынесем логику создания объекта в фабричный метод.
{
    const TYPE_CIRCLE = 'Paral';
    const TYPE_SQUARE = 'square';
    const TYPE_RECTANGLE = 'rectangle';

    public static function create($type, $param1, $param2 = null): Figure
    {
        switch ($type) {
            case self::TYPE_CIRCLE: return new Paral($param1, $param2);
            case self::TYPE_SQUARE: return new Square($param1);
            case self::TYPE_RECTANGLE: return new Rectangle($param1, $param2);
        }

        throw new \Exception('Неизвестный тип фигуры');
    }

    abstract public function getName(): string;
    abstract public function getPerimeter(): int;
    abstract public function getArea(): int;
}
?>


<?php
$figure = null;
$error = null;

if (!empty($_POST)) {
try {
$figure = Figure::create($_POST['type'], $_POST['param1'], $_POST['param2']);
} catch (Exception $e) {
$error = $e->getMessage();
}
}

?>

<?php if (!empty($error)): ?>
    <p style="color: red"><?= $error ?></p>
<?php endif ?>

<?php if (!empty($figure)): ?>
    <p>Фигура: <?= $figure->getName() ?></p>
    <p>Площадь: <?= $figure->getArea() ?></p>
    <p>Периметр: <?= $figure->getPerimeter() ?></p>
<?php endif ?>

<form method="post">
    <select name="type">
        <option value="<?= Figure::TYPE_CIRCLE ?>" <?= $_POST['type'] === Figure::TYPE_CIRCLE ? 'selected' : '' ?>>Параллелограмм</option>
        <option value="<?= Figure::TYPE_RECTANGLE ?>" <?= $_POST['type'] === Figure::TYPE_RECTANGLE ? 'selected' : '' ?>>Прямоугольник</option>
        <option value="<?= Figure::TYPE_SQUARE ?>" <?= $_POST['type'] === Figure::TYPE_SQUARE ? 'selected' : '' ?>>Квадрат</option>
    </select>
    <label>
        Параметр 1
        <input name="param1" value="<?= $_POST['param1'] ?>">
    </label>
    <label>
        Параметр 2
        <input name="param2" value="<?= $_POST['param2'] ?>">
    </label>
    <input type="submit" value="Рассчитать">
</form>
<?php
class Paral extends Figure
{
    private $height;
    private $side;

    public function __construct(int $side, int $height)
    {
        if (empty($side)) {
            throw new \Exception('Не указана сторона параллелограмма!');
        }
        if (empty($height)) {
            throw new \Exception('Не указана высота параллелограмма!');
        }
        $this->side = $side;
        $this->height = $height;
    }

    public function getName(): string
    {
        return 'Параллелограмм';
    }

    public function getPerimeter(): int
    {
        return 2 * ($this->side + $this->height);
    }

    public function getArea(): int
    {
        return $this->side * $this->height;
    }
}
class Rectangle extends Figure
{
    private  $width;
    private $height;

    public function __construct(int $width, int $height)
    {
        if (empty($width)) {
            throw new \Exception('Не указана ширина прямоугольника');
        }
        if (empty($height)) {
            throw new \Exception('Не указана высота прямоугольника');
        }
        $this->width = $width;
        $this->height = $height;
    }

    public function getName(): string
    {
        return 'Прямоугольник';
    }

    public function getPerimeter(): int
    {
        return ($this->width + $this->height) * 2;
    }

    public function getArea(): int
    {
        return $this->width * $this->height;
    }
}
class Square extends Figure
{
    protected $side;

    public function __construct(int $side)
    {
        if (empty($side)) {
            throw new \Exception('Не указана сторона квадрата');
        }
        if ($side < 0) {
            throw new \Exception('Сторона квадрата не может быть отрицательной');
        }
        $this->side = $side;
    }

    public function getName(): string
    {
        return 'Квадрат';
    }

    public function getPerimeter(): int
    {
        return $this->side * 4;
    }

    public function getArea(): int
    {
        return pow($this->side, 2);
    }


}


?>
</body>
</HTML>
