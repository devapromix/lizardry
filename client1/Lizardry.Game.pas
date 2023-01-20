unit Lizardry.Game;

interface

type
  TGame = class(TObject)
  private

  public
    constructor Create;
    destructor Destroy; override;
    procedure Enter;
  end;

var
  Game: TGame;

implementation

{ TGame }

constructor TGame.Create;
begin

end;

destructor TGame.Destroy;
begin

  inherited;
end;

procedure TGame.Enter;
begin

end;

end.
