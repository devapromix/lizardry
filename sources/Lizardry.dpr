program Lizardry;

uses
  Vcl.Forms,
  Lizardry.FormMain in 'Lizardry.FormMain.pas' {FormMain},
  Lizardry.FrameLogin in 'Lizardry.FrameLogin.pas' {FrameLogin: TFrame},
  Lizardry.FrameRegistration in 'Lizardry.FrameRegistration.pas' {FrameRegistration: TFrame},
  Lizardry.Server in 'Lizardry.Server.pas',
  Lizardry.Frame.Location.Town in 'Lizardry.Frame.Location.Town.pas' {FrameTown: TFrame},
  Lizardry.Game in 'Lizardry.Game.pas',
  Lizardry.JSON in 'Lizardry.JSON.pas',
  Lizardry.FrameBank in 'Lizardry.FrameBank.pas' {FrameBank: TFrame},
  Lizardry.FrameDefault in 'Lizardry.FrameDefault.pas' {FrameDefault: TFrame};

{$R *.res}

begin
  Application.Initialize;
  Application.MainFormOnTaskbar := True;
  Application.CreateForm(TFormMain, FormMain);
  Application.Run;
end.
