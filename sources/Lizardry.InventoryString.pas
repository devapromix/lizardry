unit Lizardry.InventoryString;

interface

uses Classes;

type
  TInventoryString = class(TObject)
  private
  public
    constructor Create;
    destructor Destroy; override;
  end;

implementation

uses Math, SysUtils;

{ TInventoryString }

constructor TInventoryString.Create;
begin

end;

destructor TInventoryString.Destroy;
begin

  inherited;
end;

end.
