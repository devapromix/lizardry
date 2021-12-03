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
  Lizardry.FrameDefault in 'Lizardry.FrameDefault.pas' {FrameDefault: TFrame},
  Lizardry.FrameTavern in 'Lizardry.FrameTavern.pas' {FrameTavern: TFrame},
  Lizardry.FrameOutlands in 'Lizardry.FrameOutlands.pas' {FrameOutlands: TFrame},
  Lizardry.FrameBattle in 'Lizardry.FrameBattle.pas' {FrameBattle: TFrame},
  Lizardry.FrameLoot in 'Lizardry.FrameLoot.pas' {FrameLoot: TFrame},
  Lizardry.FrameInfo in 'Lizardry.FrameInfo.pas' {FrameInfo: TFrame},
  Lizardry.FormInfo in 'Lizardry.FormInfo.pas' {FormInfo},
  Lizardry.FrameChat in 'Lizardry.FrameChat.pas' {FrameChat: TFrame},
  Lizardry.FrameShop in 'Lizardry.FrameShop.pas' {FrameShop: TFrame},
  Lizardry.FormPrompt in 'Lizardry.FormPrompt.pas' {FormPrompt},
  Lizardry.FormMsg in 'Lizardry.FormMsg.pas' {FormMsg},
  Lizardry.InventoryString in 'Lizardry.InventoryString.pas',
  Lizardry.FrameChar in 'Lizardry.FrameChar.pas' {FrameChar: TFrame},
  Lizardry.FrameUpdate in 'Lizardry.FrameUpdate.pas' {FrameUpdate: TFrame};

{$R *.res}

begin
  Application.Initialize;
  Application.MainFormOnTaskbar := True;
  Application.CreateForm(TFormMain, FormMain);
  Application.CreateForm(TFormInfo, FormInfo);
  Application.CreateForm(TFormPrompt, FormPrompt);
  Application.CreateForm(TFormMsg, FormMsg);
  Application.Run;
end.
